<?php

class WarehouseCartBuilded {
	
	private $outgoing;
	private $filtered;
	
	public function __construct(FormOutgoing $outgoing)
	{
		$this->outgoing = $outgoing;
	}
	
	private function checkAndFilter()
	{
		if ($this->outgoing->agent == 0) 
			throw new WarehouseCartBuildedException("Contragent must be selected");
		
		$this->filtered = new FilteredNNSelection($this->outgoing->selection);
		if ($this->filtered->isEmpty()) 
			throw new WarehouseCartBuildedException("selection must be not null");
	}
	
	private function save()
	{
		foreach ($this->filtered->getData() as $key=>$item)
			(new WarehouseCart($this->outgoing->agent, $key, $item['pp_qty']))
				->save();
	}
	
	public function build()
	{
		$this->checkAndFilter();
		$this->save();
	}
}
