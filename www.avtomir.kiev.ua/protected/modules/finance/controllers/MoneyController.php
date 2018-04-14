<?php

class MoneyController extends FinanceController
{
	public function actionAdd()
	{
		$this->render('add',[
            'model'=>new DbMoney(),
            'cagents'=>new DbCagent()
		]);
	}

    public function actionAddSubmit()
    {
        // добавляем деньги
        if(isset($_POST['DbMoney']))
        {
            $model=new DbMoney();
            $model->attributes=$_POST['DbMoney'];
            if($model->validate())
            {
                $model->save();
            }
        }

        // переадресовываем на страницу с балансом
        $this->redirect(['balance/index']);
    }

	public function actionIndex()
	{
		$this->render('index');
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}