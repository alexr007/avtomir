<?php

class WarehouseModule extends CWebModule
{
	public $defaultController = 'dbWarehouse';
	
	public function init()
	{
		$this->registerAssets();
		
		$this->setImport(array(
			'warehouse.models.*',
			'warehouse.models.db.*',
			'warehouse.components.*',
			'warehouse.controllers.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
	
	public function registerAssets() {
		Yii::app()->getClientScript()->registerCoreScript('jquery.ui');
	}
}
