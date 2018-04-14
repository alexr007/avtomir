<?php

class PricedController extends PriceController
{
	public function actionIndex()
	{
		(new nsPriceFound($this, $_POST, $_GET))->run();
	}

	public function actionToCart()
	{
		new MoveQueryToCart();
		
		$this->redirect(
			Yii::app()->createUrl("price/cart/index")
		);
	}
}