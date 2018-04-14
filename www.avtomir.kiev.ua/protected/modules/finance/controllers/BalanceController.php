<?php

class BalanceController extends FinanceController
{
	public function actionIndex()
	{
		$model = new DbBalanceTotal('search');
	    if (isset($_GET['DbBalanceTotal'])) {
	        $model->attributes = $_GET['DbBalanceTotal'];
        }
	    $this->render('index',[
            'model'=>$model,
            'stat'=>DbBalanceTotalStatistics::model()->find(),
        ]);
	}
}