<?php

class UserAdminController extends AccessController
{
	//public $layout='//layouts/column2';
	
	/*
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	public function accessRules()
	{
		return [
			['allow',  // all users
				'actions'=>[
							'create','login','restore','createok','createerr'],
				'users'=>['*'],
			],
			['allow', //  authenticated users
				'actions'=>[
							'loginok','view','logout','profile'],
				'users'=>['@'],
			],
			['allow', // allow admin users
				'actions'=>['admin','delete','acreate','update'],
				'users'=>['admin','alexr'],
			],
			['deny',  // deny all users
				'users'=>['*'],
			],
		];
	}
	*/

	///////////////////////////////////////////////////////////////////////////////////////////////////////
	
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function actionCreate()
	{
		$model=new DbUser;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['DbUser']))
		{
			$model->attributes=$_POST['DbUser'];
			if($model->save())
				$this->redirect(['admin']);
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

		if(isset($_POST['CUser']))
		{
			$model->attributes=$_POST['CUser'];
			
			if($model->save())
				$this->redirect(['admin']);
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
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	public function actionAdmin()
	{
		$model=new DbUser('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['DbUser']))
			$model->attributes=$_GET['DbUser'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model=DbUser::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
}