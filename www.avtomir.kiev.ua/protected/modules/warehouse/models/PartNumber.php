<?php

class PartNumber {
	
	private $vendor;
	private $number;
	
	public function __construct($vendor, Number $number)
	{
		$this->vendor = $vendor;
		$this->number = $number;
	}
	
	public function id()
	{
		if ($ar = DbPartNumber::model()->findByAttributes([
				'pn_vendor'=>$this->vendor,
				'pn_number'=>$this->number->id()])
			)
			$id = $ar->pn_id;
		else {
			$dbPartNumber = new DbPartNumber();
			$dbPartNumber->pn_vendor=$this->vendor;
			$dbPartNumber->pn_number=$this->number->id();
			$dbPartNumber->save();
			$id = $dbPartNumber->pn_id;
		}
		
		return $id;
	}
	
	public function vendor()
	{
		return $this->vendor;
	}
	
	public function number()
	{
		return $this->number;
	}
}
