<?php

class DbOrderController extends WarehouseController
{
	
	// все заказы
	public function actionIndex()
	{
		$orders = new DbWarehouseOrders();
		
		$this->render('index',[
				'dataProvider'=>$orders->search()	
			]
		);
	}
	
	// заказ по номеру
	public function actionView($id)
	{
		$order = new DbWarehouseOrder();
		
		$dataProvider = $order
				->with('woCagent')
				->with('woLink')
				->with('woLink.inPnText')
				->byOrderId($id)->search();
		
		$this->render('view',[
				'order'=>$order,
				'dataProvider'=>$dataProvider
			]
		);
	}
	

}