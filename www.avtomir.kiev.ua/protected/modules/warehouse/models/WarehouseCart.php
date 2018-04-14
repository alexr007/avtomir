<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of WarehouseCart
 *
 * @author alexr
 */
class WarehouseCart {
	
	private $cagent;
	private $link;
	private $qty;
	
	public function __construct($cagent, $link, $qty) {
		$this->cagent = (int)$cagent;
		$this->link = (int)$link;
		$this->qty = (int)$qty;
	}
	
	private function checkValid()
	{
		return	($this->cagent > 0)&&
				($this->link > 0)&&
				($this->qty > 0);
	}
	
	public function save()
	{
		if ($this->checkValid())
		{
			$item = new DbWarehouseCart();
			$item->wc_cagent = $this->cagent;
			$item->wc_link = $this->link;
			$item->wc_qty = $this->qty;
			$item->save();
		}
		else 
			throw new WarehouseCartException("Agent, Item, Qty must be greater than zero");
	}
}
