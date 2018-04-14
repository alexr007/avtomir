<?php
class DestinationProperties extends CComponent
{
	private $_destination;
	private $_route; // operator
	private $_method;

	public function setDestination($value = null)
	{
		$this->_destination=$value;
		return $this;
	}
	
	public function getDestination()
	{
		return $this->_destination;
	}
	
	public function setRoute($value = null)
	{
		$this->_route=$value;
		return $this;
	}
	
	public function getRoute()
	{
		return $this->_route;
	}
	
	public function setMethod($value = null)
	{
		$this->_method=$value;
		return $this;
	}
	
	public function getMethod()
	{
		return $this->_method;
	}

	public function __construct($destination, $route, $method)
	{
		$this->destination = $destination;
		$this->route = $route;
		$this->method = $method;
	}
	
	public function setProperties($value = null)
	{
		$this->destination = ($value == null) ? null : $value['destination'];
		$this->route = ($value == null) ? null : $value['route'];
		$this->method = ($value == null) ? null : $value['method'];
	}
	
	public function getProperties()
	{
		return [
			'destination'=>$this->destination,
			'route'=>$this->route,
			'method'=>$this->method,
		];
	}
	
} 