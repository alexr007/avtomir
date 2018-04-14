<?php

class PartLineRecord {
	
	private $id;
	private $qty;
	private $type;
	
	public function __construct($id, $data ) // $data = [$qty, $type]
	{
		$this->id=(int)$id;
		$this->qty=(int)$data[0];
		$this->type=(int)$data[1];
	}
	
	public function id()
	{
		return $this->id;
	}
	
	public function quantity()
	{
		return $this->qty;
	}
	
	public function deliveryType()
	{
		return $this->type;
	}
	
	public function getId()
	{
		return $this->id;
	}
	public function data()
	{
		echo "id:";
		VarDumper::dump($this->id);
		echo " qty:";
		VarDumper::dump($this->qty);
		echo " type:";
		VarDumper::dump($this->type);
		echo "<br>";
	}
	
}
