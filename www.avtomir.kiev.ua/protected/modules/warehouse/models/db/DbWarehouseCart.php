<?php

class DbWarehouseCart extends CActiveRecord
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
		return 'warehouse_cart';
	}

	public function rules()
	{
		return [
			['wc_id, wc_date, wc_cagent, wc_link, wc_qty', 'safe'],
			['wc_id, wc_date, wc_cagent, wc_link, wc_qty', 'safe', 'on'=>'search'],
		];
	}

	public function relations()
	{
		return [
			'wcCagent' => [self::BELONGS_TO, 'DbCagent', 'wc_cagent'],
			'wcLink' => [self::BELONGS_TO, 'DbIncoming', 'wc_link'],
		];
	}

	public function attributeLabels()
	{
		return array(
			'wc_id' => 'id',
			'wc_date' => 'Date',
			'wc_cagent' => 'Cagent',
			'wc_link' => 'Link',
			'wc_qty' => 'Qty',
		);
	}

	public function byCagent($cagent_id)
	{
		$this->getDbCriteria()->mergeWith(
			new CDbCriteria([
				'condition' => "wc_cagent= :cagent",
				'params'    => [':cagent' => $cagent_id]
			])				
		);
		
		return $this;		
	}
	
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('wc_id',$this->wc_id);
		$criteria->compare('wc_date',$this->wc_date,true);
		$criteria->compare('wc_cagent',$this->wc_cagent);
		$criteria->compare('wc_link',$this->wc_link);
		$criteria->compare('wc_qty',$this->wc_qty);

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
			$this->wc_date=new DbCurrentTimestamp();
			
			return true;
		}
        return false;
    }
	
	public function getDateS()
	{
		return (new DateFormatted($this->wc_date))->date();
	}
	
	public function getCagentS()
	{
		return $this->wcCagent->ca_name;
	}
	
	public function getPartNumberS()
	{
		return $this->wcLink->fullNameS;
	}
}
