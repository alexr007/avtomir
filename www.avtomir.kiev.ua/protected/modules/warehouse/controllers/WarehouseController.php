<?php

class WarehouseController extends Controller
{
	public $layout='/layouts/column2w';
	
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}
	
	public function accessRules()
	{
		$user = new RuntimeUser();
		
		if ($user->isOperator()) return [];
			else
				return [
					['deny',  // deny all users
						'users'=>['*'],
					],
				];
	}
	
}