<?php

class DbWarehouseController extends WarehouseController
{
	public $defaultAction = 'stock';
	
	public function actionStock()
	{
		$stock = new DbWarehouseStock('search');
		
		if (isset($_GET['DbWarehouseStock']))
			$stock->attributes = $_GET['DbWarehouseStock'];	
				
		$this->render('stock',[
			'stock'=>$stock,
			'stat'=>DbWarehouseStatistics::model()->find(),
		]);
	}
	
	public function actionInAll()
	{
		$this->render('inAll');
	}
	
	public function loadInModel($id)
	{
		$model=DbIncoming::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	public function actionInEdit($id)
	{
		$model=$this->loadInModel($id);
		$model->scenario = 'edit'; // можно менять только цену, количество или вес

		if(isset($_POST['DbIncoming']))
		{
			$model->attributes=$_POST['DbIncoming'];
			
			if($model->save())
				$this->redirect(['inAll']);
		}

		$this->render('inEdit',array(
			'model'=>$model,
		));
	}
	
	public function actionInDelete($id)
	{
		if(!isset($_GET['ajax'])) return false;
		
		$this->loadInModel($id)->delete();
		$this->redirect(['inAll']);
	}
	
	//----------------------------------------------------------
	
	public function actionInNew()
	{
		$incoming = new FormIncoming();
		
		$this->render('inNew',[
			'model'=>$incoming,
		]);
	}
	
	public function actionInNewSave()
	{
		$in = new FormIncoming();
		$in->attributes = $_POST['FormIncoming'];

		try {
			$message=(new Incoming(
					$in->agent, 
					new PartNumber(
							$in->vendor,
							new Number( new NormalizedPartNumber($in->number))
						),
					$in->qty, 
					$in->weight, 
					$in->price
				)
			)->save();
		} catch (NormalizedPartNumberException $e)
		{
			$message = $e->getMessage();
		}
		
		echo $message;
	}
	
	//========================================================================
	
	public function actionOutAll()
	{
		$this->render('outAll');
	}
	
	public function actionOutNew()
	{
		$outgoing = new FormOutgoing();
		
		$this->render('outNew',[
			'outgoing'=>$outgoing,
		]);
	}
	
	public function actionOutNewItems()
	{
		// берет $outgoing->number и генерит grid
		$outgoing = new FormOutgoing();
		$outgoing->attributes = $_POST['FormOutgoing'];
		$nNumber = new NormalizedPartNumber($outgoing->number);
		
		$this->renderPartial('outItems_',[
			'dataProvider'=>(new DbWarehouseStock())->byPart($nNumber)->search(),
		]);
	}
	
	public function actionOutNewSave()
	{
		$outgoing = new FormOutgoing();
		$outgoing->attributes = $_POST['FormOutgoing'];

		try {
			$wcb = new WarehouseCartBuilded($outgoing);
			$wcb->build();
		} catch (WarehouseCartBuildedException $e) {
			echo $e->getMessage();
		}
		
		$this->redirect(
			Yii::app()->createUrl("warehouse/dbCart")
		);
	}
	
	//========================================================================
}
