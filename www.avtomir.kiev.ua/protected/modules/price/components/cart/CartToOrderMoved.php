<?php

class CartToOrderMoved {
	
	private $user;
	private $order;
	
	public function __construct(IRuntimeUser $user)
	{
		$this->user = $user;
		$this->moved();
	}
	
	private function moved()
	{
		if ($this->user->isGuest()) return false;
		// создали ордер
		$this->order = new DbCreateNewOrder($this->user);
		// корзину загрузили
		$dbCart = DbCart::model()->findAllByAttributes(['ct_user'=>$this->user->id()]);
		// перенесли
		foreach ($dbCart as $dbCartItem)
		{
			$itemToCart = new DbOrderItem();
			$itemToCart->fillWith([
				'oi_order' => $this->order->id(), 
				'oi_status' => DbOrderItemStatus::OIS_NEW,
				'oi_ship_method' => $dbCartItem->ct_dtype, 
				'oi_dealer' => $dbCartItem->ct_dealer, 
				'oi_vendor' => $dbCartItem->ct_vendor, 
				'oi_number' => $dbCartItem->ct_number, 
				'oi_desc_en' => $dbCartItem->ct_desc_en, 
				'oi_desc_ru' => $dbCartItem->ct_desc_ru, 
				'oi_depot' => $dbCartItem->ct_depot,
				'oi_qty' => $dbCartItem->ct_quantity,
				'oi_price' => $dbCartItem->ct_price,  
				'oi_weight' => $dbCartItem->ct_weight, 
				'oi_volume' => $dbCartItem->ct_volume, 
				'oi_comment_user' => $dbCartItem->ct_comment_user,
				'oi_comment_oper' => $dbCartItem->ct_comment_oper, 
				//'oi_date_process' => new DbCurrentTimestamp(), 
				]);
			$itemToCart->save();
		}
		// удалить корзину
		new CartDeleteByUser($this->user);
	}


	public function orderId()
	{
		return $this->order->id();
	}
}
