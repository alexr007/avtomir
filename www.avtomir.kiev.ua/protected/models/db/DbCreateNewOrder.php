<?php

class DbCreateNewOrder {

	private $order_id;
	private $user;
	private $suffix;
	
	public function __construct(RuntimeUser $user, $suffix = "") {
		$this->user = $user;
		$this->suffix = $suffix;
		$this->createNewOrder();
	}
	
	public function id() {
		return $this->order_id;
	}
	
	private function createNewOrder()
	{
		// номер заказа
		$orderNumber = new DbNewOrderNumber();
		// заказ
		$order = new DbOrder();
		$order->o_number = $orderNumber->nextValue().$this->suffix;
		$order->o_cagent = $this->user->cagentId();
		$order->o_status = DbOrderStatus::OS_CREATED;
		$order->o_date_in = new DbCurrentTimestamp();
		$order->save();
		$this->order_id = $order->o_id;
	}
	
}
