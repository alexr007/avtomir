<?php
class ShipmentProperties extends CComponent
{
	private $_operator;
	private $_method;
	
	public function setOperator($value = null)
	{
		$this->_operator=$value;
		return $this;
	}
	
	public function getOperator()
	{
		return $this->_operator;
	}
	
	public function setMethod($value = null)
	{
		$this->_method= ($value == null) ? [] : $value;
		return $this;
	}
	
	public function getMethod()
	{
		return $this->_method;
	}
	
	public function setProperties($value = null)
	{
		$this->operator = ($value == null) ? null : $value['operator'];
		$this->method = ($value == null) ? null : $value['method'];
	}
	
	public function getProperties()
	{
		return [
			'operator'=>$this->opeator,
			'method'=>$this->method,
		];
	}
	
} 