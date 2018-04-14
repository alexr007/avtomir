<?php

class DbCartController extends WarehouseController
{
	
	// все корзины заказов
	public function actionIndex()
	{
		$carts = new DbWarehouseActiveCart();
		$this->render('index',[
				'dataProvider'=>$carts->search(),
			]
		);
	}
	
	// просмотр корзины по пользователю
	public function actionView($id)
	{
		$cart = new DbWarehouseCart();
		$dataProvider = $cart
				->with('wcLink')
				->with('wcCagent')
				->with('wcLink.inPnText')
				->byCagent($id)->search();
		
		$toOrder = new FormToOrder();
		
		$this->render('view',[
				'cagent_id'=>$id,
				'toOrder'=>$toOrder,
				'dataProvider'=>$dataProvider,
			]
		);
	}
	
	public function actionToOrder()
	{
		$toOrder = new FormToOrder();
		
		// Если ничего не отмечено - назад
		if (!isset($_POST['FormToOrder'])) {
			$this->redirect('index');
		}
		
		// user selection - from POST
		$toOrder->attributes = $_POST['FormToOrder'];
		$itemsToOrder = array_keys($toOrder->selection);
		
		$attributesToFind=['wc_cagent'=>$toOrder->cagent,'wc_id'=>$itemsToOrder];
		$partsToOrder = DbWarehouseCart::model()->findAllByAttributes($attributesToFind);
		// номер заказа
		$orderNumber = (new DbNewOrderNumber())->nextValue();
		
		foreach ($partsToOrder as $part) 
			(new WarehouseOrder(
				$part->wc_cagent,
				$part->wc_link,
				$part->wc_qty,
				0,
				$orderNumber
			))->save();

		DbWarehouseCart::model()->deleteAllByAttributes($attributesToFind);
		
		// перейти в зказ
		$this->redirect(
			Yii::app()->createUrl("warehouse/dbOrder")
		);
		
	}
}