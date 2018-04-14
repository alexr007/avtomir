<?php

class PostItem {
	private $name;
	private $value;
	
	public function __construct($name, $value) {
		$this->name = $name;
		$this->value = $value;
	}
	
	function name() {
		return $this->name;
	}

	function value() {
		return $this->value;
	}
	
	function toString() {
		return "name:".$this->name.", value:".$this->value;
	}

}
