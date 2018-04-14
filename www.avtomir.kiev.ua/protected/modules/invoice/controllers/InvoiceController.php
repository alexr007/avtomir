<?php

class InvoiceController extends Controller
{
	public $layout='/layouts/column1inv';
	
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
			['allow',
				'users'=>['*'],
			],
		];
	}
	
}