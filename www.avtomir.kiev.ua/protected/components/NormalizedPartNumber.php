<?php

/*
 * throws NormalizedPartNumberException($num);
 * if number invalid (after trimmed <3 or >32)
 * 
 */

class NormalizedPartNumber {
	
	const MIN_LENGTH = 3;
	const MAX_LENGTH = 32;
	const RULES = [
		['search'=>'/[\W]/', // разрешаем A-Z, 0-9, _
			'replace'=>''], // оставляем цифры, буквы, и _
		['search'=>'/[_]/',	
			'replace'=>'']  // удаляем подчеркивание
	];
	
	private $origin;
	
	public function __construct($number)
	{
		$this->origin = $number;
	}
	
	public function number()
	{
		$num = trim(mb_strtoupper($this->origin));
		
		foreach (self::RULES as $rule)
			$num = preg_replace($rule['search'], $rule['replace'], $num);
		
		$len = mb_strlen($num);
		
		if (($len < self::MIN_LENGTH) || ($len > self::MAX_LENGTH))
			throw new NormalizedPartNumberException($num);
		
		return $num;
	}

	public function get() {
	    return $this->number();
    }
}