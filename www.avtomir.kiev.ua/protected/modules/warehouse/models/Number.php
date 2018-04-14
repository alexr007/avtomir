<?php

/*
 * проверяет номер в базе
 * если номер есть - возвращает Id
 * если номера нет - вставляет его и возвращает Id
 * 
 */
class Number {
	
	private $origin;
	
	public function __construct(NormalizedPartNumber $number) {
		$this->origin = $number->number();
	}
	
	public function id()
	{
		if (($ar = DbNumber::model()->findByAttributes(['n_number'=>$this->origin])))
			$id = $ar->n_id;
		else {
			$dbNumber = new DbNumber();
			$dbNumber->n_number=$this->origin;
			$dbNumber->save();
			$id = $dbNumber->n_id;
		}
		
		return $id;
	}
	
	public function number()
	{
		return $this->origin;
	}
}
