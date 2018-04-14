<?php

class Parameter {
	
	private $section;
	private $name;
	
	public function __construct($section, $name) {
		$this->section = $section;
		$this->name = $name;
	}
	
	public function value()
	{
		Yii::app()->settings->deletecache();
		return Yii::app()->settings->get($this->section, $this->name);
		
	}
	
}
