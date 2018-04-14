<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ANutShell
 *
 * @author alexr
 */
abstract class ANutShell {
	
	protected $controller;
	protected $formData;
	protected $errors;
	
	public function __construct($controller = null, $dataPOST = null, $dataGET = null)
	{
		if (($controller === NULL)||($dataPOST === NULL)) 
			throw new CException('Invalid ctor call.');
		
		$this->controller = $controller;
		$this->formData = $dataPOST != null ? $dataPOST : $dataGET ;
		$this->errors = new CList();
	}
	
	protected function isErrors()
	{
		return $this->errors->count != 0;
	}
	
	protected function addError($error = null)
	{
		if ($error) 
			$this->errors->add($error);
	}
	
	protected function finishError($error = null)
	{
		$this->addError($error);
		
		$this->controller->render('_errors', 
				[ 'data' => $this->errors,
				]
			);
	}
	
	protected function renderErrors()
	{
		return
			$this->controller->renderPartial('_errors', 
				[ 'data' => $this->errors,
				],
				true // return value instead immediately output it
			);
	}
	
	protected function renderData($data)
	{
		return 
			$this->controller->renderPartial('_price', 
				[ 'data' => $data,
				],
				true
			);
	}
	
	abstract public function run();
	
}
