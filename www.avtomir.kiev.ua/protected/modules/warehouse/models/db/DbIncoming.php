<?php

class DbIncoming extends CActiveRecord
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
		return 'incoming';
	}

	public function rules()
	{
		return array(
			array('in_qty, in_weight, in_price', 'safe', 'on'=>'edit'),
			array('in_id, in_date, in_cagent, in_pn, in_qty, in_weight, in_price', 'safe'),
			array('in_id, in_date, in_cagent, in_pn, in_qty, in_weight, in_price', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'inCagent' => array(self::BELONGS_TO, 'DbCagents', 'in_cagent'),
			'inPn' => array(self::BELONGS_TO, 'DbPartNumber', 'in_pn'),
			'inPnText' => array(self::BELONGS_TO, 'DbPartNumbers', 'in_pn'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'in_id' => 'id',
			'in_date' => 'Date in',
			'in_cagent' => 'Agent',
			'in_pn' => 'PN id',
			'in_qty' => 'Qty',
			'in_weight' => 'Weight',
			'in_price' => 'Price',
			'fullNameS' => 'Part Number',
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('in_id',$this->in_id);
		$criteria->compare('in_date',$this->in_date,true);
		$criteria->compare('in_cagent',$this->in_cagent);
		$criteria->compare('in_pn',$this->in_pn);
		$criteria->compare('in_qty',$this->in_qty);
		$criteria->compare('in_weight',$this->in_weight,true);
		$criteria->compare('in_price',$this->in_price,true);

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
			$this->in_price = (new FilteredPrice($this->in_price))->value();
			$this->in_weight = (new FilteredWeight($this->in_weight))->value();
			
			if ($this->in_weight == '') $this->in_weight = null;
			
			$this->in_date=new DbCurrentTimestamp();
			
			return true;
		}
        return false;
    }
	
	public function getFullNameS()
	{
		return $this->inPnText->getFullNameS();
	}
}
