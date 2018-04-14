<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property integer $u_id
 * @property string $u_login
 * @property string $u_password
 * @property string $u_email
 * @property string $u_firstname
 * @property string $u_lastname
 * @property string $u_activation_key
 * @property string $u_created
 * @property string $u_updated
 * @property string $u_lastvisit
 * @property string $u_passwordchange
 * @property boolean $u_emailverified
 * @property boolean $u_active
 * @property boolean $u_disabled
 * @property string $u_otp_secret
 * @property string $u_otp_code
 * @property integer $u_otp_counter
 *
 * The followings are the available model relations:
 * @property UserRemoteIdentities[] $userRemoteIdentities
 * @property UserUsedpasswords[] $userUsedpasswords
 * @property UserLoginattempts[] $userLoginattempts
 * @property UserProfilePictures[] $userProfilePictures
 */
class CUser extends LActiveRecord
{
	public static $list_key_field='u_id';
	public static $list_name_field='u_login';
	public static $list_sort_field='u_id';
	
	public function tableName()
	{
		return 'users';
	}

	public function rules()
	{
		return array(
			[ 'u_login', 'safe' ],
			[ 'u_email, u_firstname, u_lastname', 'safe'],
			[ 'u_disabled', 'safe'],
			[ 'newPassword', 'safe'],
			// ['u_otp_counter', 'numerical', 'integerOnly'=>true],
			// ['u_login, u_password, u_email, u_firstname, u_lastname, u_activation_key, u_created, u_updated, u_lastvisit, u_passwordchange, u_emailverified, u_active, u_disabled, u_otp_secret, u_otp_code', 'safe'],
			// ['u_id, u_login, u_password, u_email, u_firstname, u_lastname, u_activation_key, u_created, u_updated, u_lastvisit, u_passwordchange, u_emailverified, u_active, u_disabled, u_otp_secret, u_otp_code, u_otp_counter', 'safe', 'on'=>'search'],
		);
	}

	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return [
			'userLoginattempts' => array(self::HAS_MANY, 'UserLoginattempts', 'ul_userid'),
			'userUsedpasswords' => array(self::HAS_MANY, 'UserUsedpasswords', 'up_user_id'),
			//'userRemoteIdentities' => array(self::HAS_MANY, 'UserRemoteIdentities', 'ur_user_id'),
			//'userProfilePictures' => array(self::HAS_MANY, 'UserProfilePictures', 'upp_user_id'),
			'userTags' => 			array(self::HAS_MANY, 'Tags', 'tg_user'),
		];	
	}		
	
	public function attributeLabels()
	{
		return array(
			'u_id' => 'id',
			'u_login' => 'Login',
			'u_password' => 'Password',
			'u_email' => 'E-mail',
			'u_firstname' => 'First Name',
			'u_lastname' => 'Last Name',
			'u_activation_key' => 'Activation Key',
			'u_created' => 'Created @',
			'u_updated' => 'Updated @',
			'u_lastvisit' => 'Last Visit@',
			'u_passwordchange' => 'Password changed @',
			'u_emailverified' => 'Email Verified',
			'u_active' => 'Active',
			'u_disabled' => 'Disabled',
			'u_otp_secret' => 'OTP Secret',
			'u_otp_code' => 'OTP Code',
			'u_otp_counter' => 'OTP Counter',
			'u_status' => 'Status',
			'newPassword' => 'New Password',
			'newPassword2' => 'New Password (repeat)',
		);
	}

	public function search()
	{

		$criteria=new CDbCriteria;

		$criteria->compare('u_id',$this->u_id);
		$criteria->compare('u_login',$this->u_login,true);
		$criteria->compare('u_password',$this->u_password,true);
		$criteria->compare('u_email',$this->u_email,true);
		$criteria->compare('u_firstname',$this->u_firstname,true);
		$criteria->compare('u_lastname',$this->u_lastname,true);
		$criteria->compare('u_activation_key',$this->u_activation_key,true);
		$criteria->compare('u_created',$this->u_created,true);
		$criteria->compare('u_updated',$this->u_updated,true);
		$criteria->compare('u_lastvisit',$this->u_lastvisit,true);
		$criteria->compare('u_passwordchange',$this->u_passwordchange,true);
		$criteria->compare('u_emailverified',$this->u_emailverified);
		$criteria->compare('u_active',$this->u_active);
		$criteria->compare('u_disabled',$this->u_disabled);
		$criteria->compare('u_otp_secret',$this->u_otp_secret,true);
		$criteria->compare('u_otp_code',$this->u_otp_code,true);
		$criteria->compare('u_otp_counter',$this->u_otp_counter);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function searchByCompany($id)
	{
		$criteria=new CDbCriteria;

		$criteria->compare('u_id',$this->u_id);
		$criteria->compare('u_login',$this->u_login,true);
		$criteria->compare('u_email',$this->u_email,true);
		$criteria->compare('u_firstname',$this->u_firstname,true);
		$criteria->compare('u_lastname',$this->u_lastname,true);
		
		$criteria->join = 	'JOIN user_profile ON (up_user=u_id)'.
							'JOIN user_profile_fields ON upf_id=up_field';
							
		$criteria->compare('upf_name','company');
		$criteria->compare('up_value',(string)$id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
    public function scopes()
    {
        return [
            'realonly'=>array(
                'condition'=>'u_id>0',
            ),
        ];
    }
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	// такой себе триггер: u_created, u_updated
	protected function beforeSave()
	{
		if ($this->isNewRecord) {
			$this->u_created = date('Y-m-d H:i:s');
			$this->u_status = 1; // надо заполнить профиль
			$this->u_active = true; // потом убрать, когда будет верификация
		} else {
			$this->u_updated = date('Y-m-d H:i:s');
		}
		
		if ($this->u_created==0) $this->u_created=NULL; 
		if ($this->u_updated==0) $this->u_updated=NULL; 
		if ($this->u_lastvisit==0) $this->u_lastvisit=NULL; 

		if ($this->u_password != NULL)
			$this->u_passwordchange =date('Y-m-d H:i:s');
		else
			$this->u_passwordchange = NULL; 

		
		return parent::beforeSave();
	}

	public static function hashPassword($password)
	{
		return password_hash($password, PASSWORD_DEFAULT);
	}

	public function verifyPassword($password)
	{
		return $this->u_password !== null && password_verify($password, $this->u_password);
	}

    public static function isUniqueLogin($username)
    {
		$count = (int)self::model()->dbConnection->createCommand()
            ->select('COUNT(*)')
            ->from('users')
            ->where('lower(u_login) = :username', 
					[':username'=>mb_strtolower($username)])
            ->queryScalar();
			
		return $count == 0;
    }
	
    /// id
	public function getId()
    {
		return $this->u_id;
    }
	
    /// login
	public function getLogin()
    {
		return $this->u_login;
    }
	
    /// name
	public function getName()
    {
		return $this->u_login;
    }
	
    /// newPassword
	public function getNewPassword()
    {
		return "";
    }
	
	public function setNewPassword($value = null)
    {
		$this->u_password = $this->hashPassword($value);
		return $this;
    }
}
