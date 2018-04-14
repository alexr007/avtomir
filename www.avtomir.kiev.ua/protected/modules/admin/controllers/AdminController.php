<?php

class AdminController extends Controller
{
	public $layout='/layouts/column2a';

	public function accessRules()
	{
		$user = new RuntimeUser();
		
		if ($user->isAdmin()) return [];
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