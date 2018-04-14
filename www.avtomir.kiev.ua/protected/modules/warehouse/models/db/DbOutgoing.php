<?php

class DbOutgoing extends CActiveRecord
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
		return 'outgoing';
	}

	public function rules()
	{
		return array(
			array('out_id, out_date, out_cagent, out_price, out_qty, out_link', 'safe'),
			array('out_id, out_date, out_cagent, out_price, out_qty, out_link', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'outCagent' => array(self::BELONGS_TO, 'DbCagents', 'out_cagent'),
			'outLink' => array(self::BELONGS_TO, 'DbIncoming', 'out_link'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'out_id' => 'id',
			'out_date' => 'Date',
			'out_cagent' => 'Agent',
			'out_price' => 'Price',
			'out_qty' => 'Qty',
			'out_link' => 'Link',
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('out_id',$this->out_id);
		$criteria->compare('out_date',$this->out_date,true);
		$criteria->compare('out_cagent',$this->out_cagent);
		$criteria->compare('out_price',$this->out_price,true);
		$criteria->compare('out_qty',$this->out_qty);
		$criteria->compare('out_link',$this->out_link);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	protected function beforeSave()
    {
		if (parent::beforeSave()) {
			$this->out_date=new DbCurrentTimestamp();
			
			return true;
		}
        return false;
    }
}
