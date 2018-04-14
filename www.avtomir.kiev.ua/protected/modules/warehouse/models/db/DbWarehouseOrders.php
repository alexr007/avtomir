<?php

class DbWarehouseOrders extends CActiveRecord
{
	public function tableName()
	{
		return 'warehouse_orders';
	}

	public function attributeLabels()
	{
		return array(
			'wo_cagent' => 'agent id',
			'ca_name' => 'Cagent',
			'wo_orderid' => 'order id',
			'total_numbers' => 'Total Numbers',
			'total_items' => 'Total Items',
			'total_amount' => 'Total Amount',
		);
	}

	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('wo_cagent',$this->wo_cagent);
		$criteria->compare('ca_name',$this->ca_name,true);
		$criteria->compare('wo_orderid',$this->wo_orderid,true);
		$criteria->compare('total_numbers',$this->total_items,true);
		$criteria->compare('total_items',$this->total_items,true);
		$criteria->compare('total_amount',$this->total_amount,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/*
	public function getDbConnection()
	{
		return Yii::app()->db2;
	}
	 * 
	 */

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
