<?php
class ErrorList {
	
	private $_list;
	
	public function __construct()
	{
		$this->_list = new CList();
	}
	
	public function hasErrors()
	{
		return $this->_list->count != 0;
	}
	
	public function add($error = null)
	{
		if ($error)
			$this->_list->add($error);
	}
	
	public function getErrors()
	{
		return $this->_list;
	}
	
}
