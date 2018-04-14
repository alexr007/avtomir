<?php

class PriceModule extends CWebModule
{
	public $defaultController = 'Priced';

	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'price.components.*',
			'price.components.cart.*',
			'price.components.found.*',
			'price.components.nutshells.*',
			'price.components.pricefinder.*',
			'price.components.providers.*',
			
			'price.models.*',
			'price.models.db.*',
			'price.extensions.*',
			'price.controllers.*',
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
}
