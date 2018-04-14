<?php

class DbWarehouseActiveCart extends CActiveRecord
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
		return 'warehouse_active_carts';
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		/*
		$criteria->compare('wc_id',$this->wc_id);
		$criteria->compare('wc_date',$this->wc_date,true);
		$criteria->compare('wc_cagent',$this->wc_cagent);
		$criteria->compare('wc_link',$this->wc_link);
		$criteria->compare('wc_qty',$this->wc_qty);
		 * 
		 */

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getDateS()
	{
		return (new DateFormatted($this->cart_date))->date();
	}
}
