<?php

class DbOrderStatistics extends CActiveRecord
{
	public function tableName()
	{
		return 'order_statistics';
	}

    public function getTableSchema()
    {
		// вот так делается pk для View
        // primaryKey for view
		$table = parent::getTableSchema();
		$table->primaryKey='os_orderid';
        return $table;
	}	
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getTotalUniqueNumbers()
	{
		return $this->os_cnt;
	}
	
	public function getTotalItems()
	{
		return $this->os_sum;
	}
	
	public function getTotalMoney()
	{
		return $this->os_total;
	}
}
