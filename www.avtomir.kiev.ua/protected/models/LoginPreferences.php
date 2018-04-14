<?php

class LoginPreferences {
	
	private $count;
	private $time;
	
	public function __construct() {
		$this->loadFromDb();
	}
	
	private function loadFromDb()
	{
		$this->count=(new Parameter('login', 'limit_count'))->value();
		$this->time=(new Parameter('login', 'limit_time'))->value();
	}
	
	public function failCount() {
		return $this->count;
	}
	
	public function time() {
		return $this->time;
	}
	
}
