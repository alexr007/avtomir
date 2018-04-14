<?php

class FormUserRestore extends CFormModel
{
	public $email;

	private $_identity;
	
	public function rules()
	{
		return array(
			array('email', 'required'),
			array('email', 'email'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'email'=>'E-Mail',
		);
	}

	public function seekuser()
	{
		if ($this->_identity = UserIdentity::find(['u_email'=>$this->email]))
			return true;
		else return false;
	}
	
	public function restorepassword()
	{
		$emailto = $this->_identity->email;
		
		$from = 'restore_password@amtlg.com';
		$to = $emailto;
		$subject = 'Password recovery instructions';
		$body = 'follow the link to set new password';
		mail($to, $subject, $body, "From:".$from." \r\n");
		return $emailto;
	}
}