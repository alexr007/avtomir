<?php

class FormUserProfile extends FormUserCreate
{
	public $email;
	public $firstName;
	public $lastName;

	public function rules()
	{
		return array(
			array('login, email, firstName, lastName','required'),
			array('login', 'length', 'min'=>3, 'max'=>24),
			array('login', 'match',  'pattern'=>'/^[A-Za-z]+[A-Za-z0-9_]+$/', 'message'=>'Only A-Z, 0-9, 1st letter allowed!'),
			array('email', 'email'),
			array('password', 'safe'),
        	array('password2', 'compare', 'compareAttribute'=>'password'),
			array('login', 'newUniqueUrEqual'),
		);
	}
	
	public function newUniqueUrEqual($attribute, $params)
    {       
		$message='selected login already used in database, please use another';
		if ($this->login != $this->_identity->username) {
			$this->_identity = new UserIdentity($this->$attribute,'');
			if(!$this->_identity->isUniqueLogin()) 
				$this->addError('login', $this->_identity->errorMessage);
		} 
    }
	
	public function even($attribute, $params)
    {       
		$message=strtr('{attribute} should be even.', array('{attribute}'=>$this->getAttributeLabel($attribute),));
        if ($this->$attribute%2)
            $this->addError($attribute, $message);
    }
	
	public function validate2Passwords($attribute,$params)
	{
		return;	
		$pwd = explode(',', $attribute);
		
		if ($pwd[0] != $pwd[1]) {
			$this->addError($attribute, 'Passwords must be identical');
		} else if (mb_strlen($pwd[0])<6) {	
			$this->addError($attribute, 'Passwords must 6 symbols minimum');
		}	
	}
	
	public function attributeLabels()
	{
		$labels = array(
			'email'=>'E-Mail',
			'firstName'=>'First Name',
			'lastName'=>'Last Name',
		);
		return array_merge($labels, parent::attributeLabels());
	}

	public function usersave()
	{
		if ($this->_identity->id == null)  // мы сменили логин и ID слетел на валидации, старый есть тут Yii::app()->user->id
			$this->_identity = UserIdentity::find(['u_id'=>Yii::app()->user->getId()]); //(); // возвращаем его на место
			
		// todo
		// если логин изменен - надо сделать LOGOUT + LOGIN	
		
		// загружаем измененные поля
		$this->_identity->setAttributes([
			'username'=>$this->login,
			'email'=>$this->email,
			'firstName'=>$this->firstName,
			'lastName'=>$this->lastName,
			]);
			
		if ($this->_identity->save(false)) {// false = req verif email
			
			// сохранили пароль
			$this->_identity->resetPassword($this->password);
			
			// и поменяли stage
			if ($this->_identity->isStage1register())
				$this->_identity->toStage2register();
			return true;
		}	
			else return false;
	}

}