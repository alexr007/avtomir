<?php

class MntModule extends CWebModule
{
	public $defaultController = 'db';
	
	public function init()
	{
		$this->setImport(array(
			'mnt.models.*',
			'mnt.components.*',
		));
	}

}
