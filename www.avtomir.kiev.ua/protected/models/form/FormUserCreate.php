<?php

class FormUserCreate extends CFormModel
{
	public $login;
	public $password;
	public $password2;

	public $_identity;

	public function rules()
	{
		return array(
			array('login, password, password2', 'required'),
			array('login', 'length', 'min'=>4, 'max'=>24),
			array('login', 'match',  'pattern'=>'/^[A-Za-z]+[A-Za-z0-9_]+$/', 'message'=>'Only A-Z, 0-9, 1st letter allowed!'),
			array('login', 'newunique'),
			array('password, password2', 'length', 'min'=>6, 'max'=>48),
            array('password2', 'compare', 'compareAttribute'=>'password'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'login'=>'Login',
			'password'=>'Password',
			'password2'=>'Password (repeat)',
		);
	}
	
	public function getIdentity()
	{
		if ($this->_identity == null)
			$this->_identity = UserIdentity::find(['u_id'=>Yii::app()->user->getId()]);
		return $this->_identity;
	}

	public function setIdentity()
	{
		$this->_identity = $this->getIdentity();
	}
	
	public function newunique($attribute,$params)
	{
		// $attribute - имя поля
		// $this->$attribute - значение имени поля класса
		$this->_identity = new UserIdentity($this->$attribute,'');
		
		if(!$this->_identity->isUniqueLogin()) {
			$this->addError('login', $this->_identity->errorMessage);
		} 
	}

	public function usercreate()
	{
		$this->_identity=new UserIdentity($this->login,$this->password);
		if ($this->_identity->isUniqueLogin()) {
			$this->_identity->save(false); // false = req verif email
			$this->_identity->resetPassword($this->password);
			return true;
		} else
			return false;
	}

}