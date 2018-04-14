<?php

class NormalizedPartNumberException extends Exception
{
	public function __construct($number = "")
	{
		//$message = "", $code = 0, Exception $previous = null)
		$message = 'Invalid Part Number given: '.$number;
		parent::__construct($message, 0, null);
	}
}
