<?php

class SearchHistoryController extends AdminController
{
	public function loadModel($id)
	{
		$model=DbPartSearchHistory::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	public function actionIndex()
	{
		$history = new DbPartSearchHistory('search');
		$history->unsetAttributes();  // clear any default values
		
		if(isset($_GET['DbPartSearchHistory']))
			$history->attributes=$_GET['DbPartSearchHistory'];

		$this->render('index',[
			'history'=>$history,
		]);
	}

	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}
}