<?php

class Incoming {
	
	private $cagent;
	private $pn;
	private $qty;
	private $weight;
	private $price;
		
	public function __construct($cagent, PartNumber $pn, $qty, $weight, $price)
	{
		$this->cagent = $cagent;
		$this->pn = $pn;
		$this->qty = $qty;
		$this->weight = $weight;
		$this->price = $price;
	}
	
	public function save()
	{
		$dbIncoming = new DbIncoming();
		$dbIncoming->in_cagent = $this->cagent;
		$dbIncoming->in_pn = $this->pn->id();
		$dbIncoming->in_qty = $this->qty;
		$dbIncoming->in_weight = $this->weight;
		$dbIncoming->in_price = $this->price;
		$dbIncoming->save();
		return $this->message();
	}

	public function message() {
		$n = $this->pn->number()->number();
		return "part number: <b>$n</b> added successfully";
	}

}
