<?php

class CartController extends PriceController {
	
	public function actionIndex()
	{
		$this->render('cart', [
				'dbCart' => new DbCart(),
			]
		);
	}
	
	public function actionCartDeleteItem($id)
	{
		$cartItem = DbCart::loadById($id);
		$cartItem->delete();
	}
	
	public function actionCartEditItem($id)
	{
		if(isset($_POST['DbCart']))
		{
			$cartItem = new DbCart();
			$cartItem->attributes=$_POST['DbCart'];
			//if($model->save())
				//$this->redirect(['toCart']);
			Yii::app()->end();
		} 
		
		$this->render('cartEdit',[
				'cartItem' => DbCart::loadById($id)
			]
		);
	}
	
	public function actionCartViewItem($id)
	{
		$this->render('cartView',[
				'cartItem' => DbCart::loadById($id)
			]
		);
	}
	
	public function actionToOrder()
	{
		try {
			new CartToOrderMoved( new RuntimeUser() ); //->orderId();
			
			$this->redirect(
					Yii::app()->createUrl("price/order/index")
				);
					
		} catch (RuntimeUserException $e) {
			$this->finishError($e);
		}
		
	}
	
}
