<?php

class UserIdentity extends CUserIdentity
{
	const STATUS_REGISTER_STAGE_1=1;
	const STATUS_REGISTER_STAGE_2=2;
	
	const ERROR_USER_DISABLED=1000;
	const ERROR_USER_INACTIVE=1001;
	const ERROR_USER_LOCKED=1002;
	const ERROR_USER_NONUNIQUE=1003;

	const ERROR_AKEY_NONE=0;
	const ERROR_AKEY_INVALID=1;
	const ERROR_AKEY_TOO_OLD=2;

	/*
	const MAX_FAILED_LOGIN_ATTEMPTS = 5;
	const LOGIN_ATTEMPTS_COUNT_SECONDS = 1800;
	 */

	public $firstName = null;
	public $lastName = null;
	public $email = null;
	
	private $_id = null;
	private $_activeRecord = null;
	
	private $loginPreferences;

	public function __construct($username,$password)
	{
		parent::__construct($username,$password);
		$this->username=mb_strtolower($username);
		$this->loginPreferences = new LoginPreferences();
	}
	
	protected static function createFromUser($user) //createFromUser(User $user) 
	{
		$identity = new UserIdentity($user->u_login, null);
		$identity->initFromUser($user);
		return $identity;
	}

	protected function initFromUser($user) // initFromUser(User $user) 
	{
		$this->_activeRecord = $user;
		$this->id = $user->getPrimaryKey();
		$this->username = $user->u_login;
		$this->firstName = $user->u_firstname;
		$this->lastName = $user->u_lastname;
		$this->email = $user->u_email;
	}

	protected function getActiveRecord()
	{
		if ($this->_activeRecord === null && $this->_id !== null) {
			$this->_activeRecord = DbUser::model()->findByPk($this->_id);
		}
		return $this->_activeRecord;
	}

	// {{{ IUserIdentity

    public function authenticate()
    {
        $record = DbUser::model()->findByAttributes( ['u_login'=>$this->username] );
        $authenticated = $record !== null && $record->verifyPassword($this->password);
		
		$ul = new UserLoginattempt($this->username, $authenticated, $authenticated ? $record->u_id : 0);
		
        //if ($ul->hasTooManyFailedAttempts($this->username, self::MAX_FAILED_LOGIN_ATTEMPTS, self::LOGIN_ATTEMPTS_COUNT_SECONDS)) {
        if ($ul->hasTooManyFailedAttempts($this->username, $this->loginPreferences->failCount(), $this->loginPreferences->time())) {
            $this->errorCode=self::ERROR_USER_LOCKED;
            $this->errorMessage='User account has been locked due to too many failed login attempts. Try again later.';
			
        } elseif (!$authenticated) {
            $this->errorCode=self::ERROR_USERNAME_INVALID;
            $this->errorMessage='Invalid username or password.';
			
        } elseif ($record->u_disabled) {
            $this->errorCode=self::ERROR_USER_DISABLED;
            $this->errorMessage='User account has been disabled.';
			
        } else if (!$record->u_active) {
            $this->errorCode=self::ERROR_USER_INACTIVE;
            $this->errorMessage='User account has not been activated yet.';
			
        } else {
            $this->errorCode=self::ERROR_NONE;
            $this->errorMessage='';
            $this->initFromUser($record);
            $record->saveAttributes([	'u_lastvisit' => date('Y-m-d H:i:s')	]);
        }
        return $this->getIsAuthenticated();
    }

    public function isUniqueLogin()
    {
		$unique = DbUser::isUniqueLogin($this->username);
		if (!$unique) {
            $this->errorCode=self::ERROR_USER_NONUNIQUE;
            $this->errorMessage='User Login already in use. Please use another';
		}
		return $unique;
    }

	public function setId($id)
	{
		$this->_id = $id;
	}

	public function getId()
	{
		return $this->_id;
	}
    
	// {{{ PasswordHistoryIdentityInterface

	/**
	 * Returns the date when specified password was last set or null if it was never used before.
	 * If null is passed, returns date of setting current password.
	 * @param string $password new password or null if checking when the current password has been set
	 * @return string date in YYYY-MM-DD format or null if password was never used.
	 */
	public function getPasswordDate($password = null)
	{
		if (($record=$this->getActiveRecord()) === null)
			return null;

		if ($password === null) {
			return $record->u_passwordchange;
		} else {
			foreach($record->userUsedPasswords as $usedPassword) {
				if ($usedPassword->verifyPassword($password))
					return $usedPassword->up_seton;
			}
		}
		return null;
	}

	/**
	 * Changes the password and updates last password change date.
	 * Saves old password so it couldn't be used again.
	 * @param string $password new password
	 * @return boolean
	 */
	 
	public function logUsedPassword($hashedPassword)
	{
		$usedPassword = new DbUserUsedPassword;
		
		$usedPassword->setAttributes([
			'up_user_id'=>$this->_id,
			'up_password'=>$hashedPassword,
			'up_seton'=>date('Y-m-d H:i:s'),
		], false);
		
		return $usedPassword->save();
	}
	 
	public function resetPassword($password)
	{
		if (($record=$this->getActiveRecord())===null) {
			return false;
		}
		$hashedPassword = DbUser::hashPassword($password);
		
		$this->logUsedPassword($hashedPassword);
		
		return $record->saveAttributes([
				'u_password'=>$hashedPassword,
				'u_passwordchange'=>date('Y-m-d H:i:s'),
			]);
	}

	// {{{ EditableIdentityInterface

	/**
	 * Saves a new or existing identity. Does not set or change the password.
	 * @see IPasswordHistoryIdentity::resetPassword()
	 * Should detect if the email changed and mark it as not verified.
	 * @param boolean $requireVerifiedEmail
	 * @return boolean
	 */
	public function save($requireVerifiedEmail=false)
	{
		if ($this->_id === null) {
			$record = new DbUser;
			$record->u_password = 'x';
			$record->u_active = $requireVerifiedEmail ? 0 : 1;
		} else {
			$record = $this->getActiveRecord();
		}
		if ($record!==null) {
			$record->setAttributes([
				'u_login' => $this->username,
				'u_email' => $this->email,
				'u_firstname' => $this->firstName,
				'u_lastname' => $this->lastName,
			]);
			if ($record->save()) {
				$this->_id = $record->getPrimaryKey();
				$this->initFromUser($record);
				return true;
			}
			Yii::log('Failed to save user: '.print_r($record->getErrors(),true), 'warning');
		} else {
			Yii::log('Trying to save UserIdentity but no matching User has been found', 'warning');
		}
		return false;
	}

	/**
	 * Sets attributes like username, email, first and last name.
	 * Password should be changed using only the resetPassword() method from the IPasswordHistoryIdentity.
	 * @param array $attributes
	 * @return boolean
	 */
	public function setAttributes(array $attributes)
	{
		$allowedAttributes = [ 
		'username', 
		'email', 'firstName', 'lastName',
		];
		foreach($attributes as $name=>$value) {
			if (in_array($name, $allowedAttributes))
				$this->$name = $value;
		}
		return true;
	}

	/**
	 * Returns attributes like username, email, first and last name.
	 * @return array
	 */
	public function getAttributes()
	{
		return array(
			'login' => $this->username,
			'email' => $this->email,
			'firstName' => $this->firstName,
			'lastName' => $this->lastName,
		);
	}

	// {{{ ActivatedIdentityInterface

	public static function find(array $attributes)
	{
		$records = DbUser::model()->findAllByAttributes($attributes);
        if (count($records)!==1) {
            return null;
        }
        $record = reset($records);
		return self::createFromUser($record);
	}

	public function isStage1register()
	{
		if (($record=$this->getActiveRecord())===null) {
			return false;
		}
		return (bool)($record->u_status==self::STATUS_REGISTER_STAGE_1);
	}
	
	public function toStage2register()
	{
		if (($record=$this->getActiveRecord())===null) {
			return false;
		}
		$record->u_status = self::STATUS_REGISTER_STAGE_2;
		if ($record->save()) {
			return true;
		}
		return false;
	}
	
	public function isActive()
	{
		if (($record=$this->getActiveRecord())===null) {
			return false;
		}
		return (bool)$record->u_active;
	}

	public function isDisabled()
	{
		if (($record=$this->getActiveRecord())===null) {
			return false;
		}
		return (bool)$record->u_disabled;
	}

	public function isVerified()
	{
		if (($record=$this->getActiveRecord())===null) {
			return false;
		}
		return (bool)$record->u_emailverified;
	}

	public function getActivationKey()
	{
		if (($record=$this->getActiveRecord())===null) {
			return false;
		}
		$activationKey = md5(time().mt_rand().$record->u_login);
		if (!$record->saveAttributes(['u_activation_key' => $activationKey])) {
			return false;
		}
		return $activationKey;
	}

	public function verifyActivationKey($activationKey)
	{
		if (($record=$this->getActiveRecord())===null) {
			return self::ERROR_AKEY_INVALID;
		}
		return $record->u_activation_key === $activationKey ? self::ERROR_AKEY_NONE : self::ERROR_AKEY_INVALID;
	}

	public function verifyEmail($requireVerifiedEmail=false)
	{
		if (($record=$this->getActiveRecord())===null) {
			return false;
		}
		/**
		 * Only update $record if it's not already been updated, otherwise
		 * saveAttributes will return false, incorrectly suggesting
		 * failure.
		 */
		if (!$record->u_email_verified) {
			$attributes = array('u_email_verified' => 1);

			if ($requireVerifiedEmail && !$record->u_active) {
				$attributes['u_active'] = 1;
			}
			if (!$record->saveAttributes($attributes)) {
				return false;
			}
		}
		return true;
	}

	public function getEmail()
	{
		return $this->email;
	}

	// {{{ IManagedIdentity

	public function getDataProvider(SearchForm $searchForm)
	{
		$criteria=new CDbCriteria;

		$criteria->compare('u_id', $searchForm->id);
		$criteria->compare('u_login', $searchForm->username,true);
		$criteria->compare('u_email', $searchForm->email,true);
		$criteria->compare('u_firstname', $searchForm->firstName,true);
		$criteria->compare('u_lastname', $searchForm->lastName,true);
		$criteria->compare('u_created', $searchForm->createdOn);
		$criteria->compare('u_updated', $searchForm->updatedOn);
		$criteria->compare('u_lastvisit', $searchForm->lastVisitOn);
		$criteria->compare('u_email_verified', $searchForm->emailVerified);
		$criteria->compare('u_active', $searchForm->isActive);
		$criteria->compare('u_disabled', $searchForm->isDisabled);
		
		$dataProvider = new CActiveDataProvider('User', array('criteria'=>$criteria, 'keyAttribute'=>'u_id'));
		
		$identities = array();
		foreach($dataProvider->getData() as $row) {
			$identities[] = self::createFromUser($row);
		}
		$dataProvider->setData($identities);
		return $dataProvider;
	}

	public function toggleStatus($status)
	{
		if (($record=$this->getActiveRecord())===null) {
			return false;
		}
		switch($status) {
			case self::STATUS_EMAIL_VERIFIED: $attributes['u_email_verified'] = !$record->u_email_verified; break;
			case self::STATUS_IS_ACTIVE: $attributes['u_active'] = !$record->u_active; break;
			case self::STATUS_IS_DISABLED: $attributes['u_disable'] = !$record->u_disabled; break;
		}
		return $record->saveAttributes($attributes);
	}

	public function delete()
	{
		if (($record=$this->getActiveRecord())===null) {
			return false;
		}
		return $record->delete();
	}

	public function getTimestamps($key=null)
	{
		if (($record=$this->getActiveRecord())===null) {
			return false;
		}
		$timestamps = array(
			'createdOn' => $record->u_created,
			'updatedOn' => $record->u_updated,
			'lastVisitOn' => $record->u_lastvisit,
			'passwordSetOn' => $record->u_passwordchange,
		);
		// can't use isset, since it returns false for null values
		return $key === null || !array_key_exists($key, $timestamps) ? $timestamps : $timestamps[$key];
	}
}
