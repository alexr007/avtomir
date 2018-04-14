<?php

/**
 * Description of PartNumber
 * 
 * input: $number - text from user input buffer
 * 
 * output: $number - trimmed, cleaned number, ready to work (if OK)
 * if errors - getErrors() - returns array of string w/errors
 * 
 * using:
 *		pn = new PartNumber('  51350-S3VA03  ');
 *		echo pn->number();
 *		if (pn->hasErrors()) {
 *			// just array werrors
 *			$errors = pn->getErrors(); 
 *			// full message in array w/strings
 *			$errors = pn->getErrorsMessage(); 
 *			// full message HTML formatted. Lines break are "<br>"
 *			$errors = getErrorsMessageFormated(new FormatMessage('html'));
 *			// full message TEXT formatted. Lines break are "\n"
 *			$errors = getErrorsMessageFormated(new FormatMessage('text'));
 *		}
 * 
 * @author alexr
 */
class PartNumbers {
	
	private $original_number;
	private $canonical_number;
	
	private $errors;

	const MIN_LENGTH = 3;
	const MAX_LENGTH = 32;
	const NA_NUMBER = "";
	
	public function __construct($number)
	{
		$this->original_number = $number;
		$this->canonical_number = null;
		$this->errors = new ErrorList();
		$this->runIfNeed();
	}
	
	public function number()
	{
		return $this->canonical_number;
	}
	
	private function runIfNeed()
	{
		if ($this->canonical_number === null)
			$this->processNumber();
	}

	private function processNumber()
	{
		$stripSymbols = ["/ /","/-/","/_/"];
		
		// убираем пробелы и табы с начала и конца
		$number = trim($this->original_number);
		// верхний регистр
		$number = mb_strtoupper($number);
		// удаляем лишнее
		foreach ($stripSymbols as $stripSymbol)
			$number = preg_replace($stripSymbol,"",$number);
		// если пустая строка - просто выходим без ошибок
		if (mb_strlen($number)==0) {
			$this->canonical_number = self::NA_NUMBER;
			return;
		}
		// проверяем то что получилось
		if(!preg_match("/^[A-Z0-9]+$/", $number)) 
			$this->errors->add("only letters A-Z and numbers 0-9 allowed in part number");
		if (mb_strlen($number)<self::MIN_LENGTH)
			$this->errors->add("number must be longer than 3 characters");
		if (mb_strlen($number)>self::MAX_LENGTH)
			$this->errors->add("number must be shorter than 32 characters");
		
		$this->canonical_number = $this->errors->hasErrors() ? self::NA_NUMBER : $number;
	}
	
	public function hasErrors()
	{
		return $this->errors->hasErrors();
	}
	
	public function getErrorsMessage()
	{
		return !$this->hasErrors() ? "" :
			array_merge(
				['Part number '.$this->original_number.' has following Errors:'],
				$this->errors->getErrors()
			);
	}
	
	public function getErrorsMessageFormated(IFormatMessage $format)
	{
		return implode($format->glue(), $this->getErrorsMessage());
	}
	
}

