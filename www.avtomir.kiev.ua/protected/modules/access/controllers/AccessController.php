<?php

class AccessController extends Controller
{
	public $layout='/layouts/column2access';
	
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}
	
	public function accessRules()
	{
		$runtimeUser = new RuntimeUser();
		
		if ($runtimeUser->isAdmin() || $runtimeUser->isOperator())
			return [];
		else
			return [
				['deny',  // deny all users
					'users'=>['*'],
				],
			];
	}
	
	public function actionIndex()
	{
		$this->render('index');
	}
	
}