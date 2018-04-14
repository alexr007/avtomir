<?php

class YiiFinish {
	
	public function __construct()
	{
		Yii::app()->end();
	}
	
}
