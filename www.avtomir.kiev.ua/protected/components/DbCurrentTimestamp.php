<?php

class DbCurrentTimestamp extends CDbExpression {
	
	public function __construct()
	{
		parent::__construct('NOW()');
	}
}
