<?php

class FormUserLogin extends CFormModel
{
	public $login;
	public $password;
	public $rememberMe;

	private $_identity;
	
	public function rules()
	{
		return array(
			array('login, password', 'required'),
			array('rememberMe', 'boolean'),
			array('password', 'authenticate'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'login'=>'Login',
			'password'=>'Password',
			'rememberMe'=>'Remember Me on this computer',
		);
	}

	public function authenticate($attribute,$params)
	{
		if(!$this->hasErrors())
		{
			$this->_identity=new UserIdentity($this->login,$this->password);
			
			if(!$this->_identity->authenticate())
				$this->addError('password', $this->_identity->errorMessage);
		}
	}

	/**
	 * Logs in the user using the given login and password in the model.
	 * @return boolean whether login is successful
	 */
	public function userlogin()
	{
		if($this->_identity===null)
		{
			$this->_identity=new UserIdentity($this->login,$this->password);
			$this->_identity->authenticate();
		}

		if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
		{
			$duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days
            Yii::app()->user->login($this->_identity,$duration);
			return true;
		}
		else
			return false;
	}

}