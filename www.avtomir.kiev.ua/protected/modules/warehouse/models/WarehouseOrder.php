<?php

class WarehouseOrder {
	
	private $cagent;
	private $link;
	private $qty;
	private $price;
	private $orderid;

	public function __construct($cagent, $link, $qty, $price = null, $orderid = null) {
		$this->cagent=$cagent;
		$this->link=$link;
		$this->qty=$qty;
		$this->price=$price;
		$this->orderid=$orderid;
	}
	
	private function checkValid()
	{
		return	($this->cagent > 0)&&
				($this->link > 0)&&
				($this->qty > 0);
		/*		
		($this->price > 0)&&
				($this->orderid > 0);
		 * 
		 */
	}
	
	public function save()
	{
		if ($this->checkValid())
		{
			$item = new DbWarehouseOrder();
			$item->wo_cagent = $this->cagent;
			$item->wo_link = $this->link;
			$item->wo_qty = $this->qty;
			$item->wo_price = $this->price;
			$item->wo_orderid = $this->orderid;
			$item->save();
		}
		else 
			throw new WarehouseOrderException("Agent, Item, Qty, Price, Prder ID must be greater than zero");
	}
	
}
