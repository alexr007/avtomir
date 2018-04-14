<?php

class DbWarehouseStock extends CActiveRecord
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
		return 'warehouse_stock_price';
	}

	public function rules()
	{
		return array(
			array('in_pn, v_name, n_number, sum, in_price', 'safe'),
			array('in_pn, v_name, n_number, sum, in_price', 'safe', 'on'=>'search'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'in_pn' => 'PN_ID',
			'v_name' => 'Vendor',
			'n_number' => 'Number',
			'sum' => 'Qty',
			'in_price' => 'Price',
		);
	}

	public function byPart(NormalizedPartNumber $number)
	{
		$plain_number = $number->number();
		
		$this->getDbCriteria()->mergeWith(
			new CDbCriteria([
				'condition' => "upper(n_number) LIKE :match",
				'params'    => [':match' => "%$plain_number%"]
			])				
		);
		
		return $this;		
	}
	
	public function search()
	{
		$criteria=new CDbCriteria;

		//new DumpExit($this->attributes);
		
		$criteria->compare('in_pn',$this->in_pn);
		$criteria->compare('upper(v_name)',  mb_strtoupper($this->v_name),true);
		$criteria->compare('upper(n_number)',mb_strtoupper($this->n_number),true);
		$criteria->compare('sum',$this->sum);
		$criteria->compare('in_price',$this->in_price);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getTotalNumbers()
	{
		return "N$";
	}
	
	public function getTotalItems()
	{
		return "I$";
	}
	
	public function getTotalMoney()
	{
		return "M$";
	}
}
