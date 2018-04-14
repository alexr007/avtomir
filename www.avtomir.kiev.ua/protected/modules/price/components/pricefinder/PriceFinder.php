<?php

abstract class PriceFinder extends CComponent
{
	protected $_errors;
	protected $_result;
	protected $_search;
	protected $priceBuild;
    protected $weightBuild;
	protected $_connect; // for SOAP
	
	
	public function __construct($values = [])
	{
		// вот так одной строкой забираются параметры
		if ($values != null)
			foreach ($values as $key=>$value)
				$this->$key=$value;
		
		$this->_errors = new CList();
		$this->_result = new CList();
		$this->_connect = new CList();
		$rtUser = new RuntimeUser();
		$this->priceBuild = new PriceBuild($rtUser);
        $this->weightBuild = new WeightBuild($rtUser);
	}
	
	protected function priceModify($price)
	{
		return $this->priceBuild->price($price);
	}

    protected function weightModify($weight)
    {
        return $this->weightBuild->weight($weight);
    }

	// search
	
	protected function setSearch($value) {
		$this->_search = $value;
	}

	protected function getSearch() {
		return $this->_search;
	}

	// result
	
	public function clearResult()
	{
		$this->_result->clear();
	}
	
	public function addResult($value)
	{
		$this->_result->add($value);
	}
	
	public function getResult()
	{
		return $this->_result;
	}
	
	// errors
	
	protected function clearErrors()
	{
		$this->_errors->clear();
	}
	
	protected function addError($value)
	{
		$this->_errors->add($value);
	}

	public function getErrors()
	{
		return $this->_errors;
	}
	
	protected function hasErrors()
	{
		return $this->_errors->count != 0;
	}
	
	protected function searchItem()
	{
		return false;
	}
	
	protected function getDealerId()
	{
		return false;
	}
	
	public function search($number = null)
	{
		$this->setSearch($number);
		$this->clearErrors();
		$this->clearResult();

		return $this->searchItem();
	}
	
}