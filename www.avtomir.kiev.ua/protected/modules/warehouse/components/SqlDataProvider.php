<?php

class SqlDataProvider {
	
	private $sql;
	private $key;
	
	public function __construct($sql,$key)
	{
		$this->sql = $sql;
		$this->key = $key;
	}
	
	public function provider()
	{
		return 
			new CSqlDataProvider(Yii::app()->db2->createCommand($this->sql),
				['keyField'=>$this->key,
				'pagination'=>false,	
			]);		
	}
	
}
