<?php

class AbstractAddCriteria {
	
	protected $criteria;
	
	public function __construct($object = null) 
	{
		$this->criteria = new CDbCriteria();
		
		if ($object)
			$this->criteria->mergeWith($this->byEntity($object));
	}
	
	public function criteria()
	{
		return $this->criteria;
	}		
	
	protected function byEntity($object)
	{
		return new CDbCriteria();
	}
}
