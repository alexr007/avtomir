<?php

class PaymentsController extends FinanceController
{
	public function actionIndex()
	{
        $model=(new DbMoney('search'))
            ->with('moCagent');

        $model->unsetAttributes();  // clear any default values

        if(isset($_GET['DbMoney'])) {
            $model->attributes=$_GET['DbMoney'];
        }

        $this->render('index',array(
            'model'=>$model,
            'cagents'=>new DbCagent(),
        ));
	}
}