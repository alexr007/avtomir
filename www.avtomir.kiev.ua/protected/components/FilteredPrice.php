<?php

class FilteredPrice {
	
	private $origin;
	
	public function __construct($val) {
		$this->origin = $val;
	}
	
	public function value()
	{
		return str_replace(',', '.', trim($this->origin));
	}
}
