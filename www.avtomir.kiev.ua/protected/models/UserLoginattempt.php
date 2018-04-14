<?php

class UserLoginattempt {

	private	$login;
	private $success;
	private $user_id;
	
	public function __construct($login, $success, $user_id)
	{
		$this->login=$login;
		$this->success=$success;
		$this->user_id=$user_id;
		
		$this->add();
	}
	
	private function add()
	{
        $attempt = new DbUserLoginAttempt();
        $attempt->ul_login = $this->login;
        $attempt->ul_successful = $this->success;
		$attempt->ul_userid = $this->user_id;
		$attempt->save();
	}
	
    public function hasTooManyFailedAttempts($username, $count_limit, $time_limit)
	{
		return DbUserLoginAttempt::hasTooManyFailedAttempts($username, $count_limit, $time_limit);
	}

	
}
