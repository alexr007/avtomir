<?php

class NumberFormatted {
	
	const FRACTIONAL = 2;
	
	private $origin;
	private $format;
	
	public function __construct($num, $fmt = self::FRACTIONAL) {
		$this->origin = $num;
		$this->format = $fmt;
	}
	
	public function value()
	{
		return $this->decimals();
	}
	
	public function decimals()
	{
		return number_format($this->origin, $this->format,'.','');
	}
	
}



