<?php

class DbWarehouseStatistics extends CActiveRecord
{
	/*
	public function getDbConnection()
	{
		return Yii::app()->db2;
	}
	 * 
	 */

	public function tableName()
	{
		return 'warehouse_statistics';
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getTotalUniqueNumbers()
	{
		return $this->cnt_uniq;
	}
	
	public function getTotalItems()
	{
		return $this->cnt_items;
	}
	
	public function getTotalMoney()
	{
		return $this->total;
	}
}
