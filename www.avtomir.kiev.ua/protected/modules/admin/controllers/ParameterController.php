<?php

class ParameterController extends AdminController
{
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	public function actionCreate()
	{
		$model=new DbParameter;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['DbParameter']))
		{
			$model->attributes=$_POST['DbParameter'];
			if($model->save())
				$this->redirect(['index']);
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['DbParameter']))
		{
			$model->attributes=$_POST['DbParameter'];
			if($model->save())
				$this->redirect(['index']);
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}

	public function actionIndex()
	{
		$model=new DbParameter('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['DbParameter']))
			$model->attributes=$_GET['DbParameter'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return DbParameter the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=DbParameter::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param DbParameter $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='db-parameter-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
