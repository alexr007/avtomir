<?php

/**
 * This is the model class for table "warehouse_order".
 *
 * The followings are the available columns in table 'warehouse_order':
 * @property integer $wo_id
 * @property string $wo_date
 * @property integer $wo_cagent
 * @property integer $wo_link
 * @property integer $wo_qty
 * @property string $wo_price
 * @property integer $wo_orderid
 *
 * The followings are the available model relations:
 * @property Cagents $woCagent
 * @property Incoming $woLink
 */
class DbWarehouseOrder extends CActiveRecord
{

	public function tableName()
	{
		return 'warehouse_order';
	}

	public function rules()
	{
		return array(
			array('wo_id, wo_date, wo_cagent, wo_link, wo_qty, wo_price, wo_orderid', 'safe'),
			array('wo_id, wo_date, wo_cagent, wo_link, wo_qty, wo_price, wo_orderid', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'woCagent' => array(self::BELONGS_TO, 'DbCagent', 'wo_cagent'),
			'woLink' => array(self::BELONGS_TO, 'DbIncoming', 'wo_link'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'wo_id' => 'Wo',
			'wo_date' => 'Wo Date',
			'wo_cagent' => 'Wo Cagent',
			'wo_link' => 'Wo Link',
			'wo_qty' => 'Wo Qty',
			'wo_price' => 'Wo Price',
			'wo_orderid' => 'Wo Orderid',
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('wo_id',$this->wo_id);
		$criteria->compare('wo_date',$this->wo_date,true);
		$criteria->compare('wo_cagent',$this->wo_cagent);
		$criteria->compare('wo_link',$this->wo_link);
		$criteria->compare('wo_qty',$this->wo_qty);
		$criteria->compare('wo_price',$this->wo_price,true);
		$criteria->compare('wo_orderid',$this->wo_orderid);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function byOrderId($order_id)
	{
		$this->getDbCriteria()->mergeWith(
			new CDbCriteria([
				'condition' => "wo_orderid= :order_id",
				'params'    => [':order_id' => $order_id]
			])				
		);
		
		return $this;		
	}
	
	/*
	public function getDbConnection()
	{
		return Yii::app()->db2;
	}
	 * 
	 */

	protected function beforeSave()
    {
		if (parent::beforeSave()) {
			$this->wo_date=new DbCurrentTimestamp();
			
			return true;
		}
        return false;
    }
	
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DbWarehouseOrder the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getDateS()
	{
		return (new DateFormatted($this->wo_date))->date();
	}
	
	public function getCagentS()
	{
		return $this->woCagent->ca_name;
	}
	
	public function getPartNumberS()
	{
		return $this->woLink->fullNameS;
	}
	
	public function getTotalLine()
	{
		return (new NumberFormatted($this->wo_qty*$this->wo_price))->value();
	}
	
	public function getTotalOrderItems($provider)
	{
	    $total=0;
	    foreach($provider->data as $item)
			$total += $item->wo_qty;
		
		return (new NumberFormatted($total,0))->value();
	}
	
	public function getTotalOrderAmount($provider)
	{
	    $total=0;
	    foreach($provider->data as $item)
			$total += $item->getTotalLine();
		
		return (new NumberFormatted($total))->value();
	}
}
