<?php

class WarehousedController extends PriceController {
	
	//public $defaultAction ='found';
	
	public function actionIndex()
	{
		(new nsWarehouseFound($this, $_POST))->run();
	}
	
	public function actionToCart()
	{
		new MoveQueryToCart();
		
		$this->redirect(
			Yii::app()->createUrl("price/cart/index")
		);
	}
	
}
