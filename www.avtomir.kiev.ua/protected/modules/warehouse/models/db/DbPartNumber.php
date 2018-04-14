<?php

class DbPartNumber extends CActiveRecord
{
//    public function getDbConnection()
//	{
//        return Yii::app()->db2;
//    }

	public function tableName()
	{
		return 'part_number';
	}

	public function rules()
	{
		return array(
			array('pn_id, pn_vendor, pn_number, pn_weight', 'safe'),
			array('pn_id, pn_vendor, pn_number, pn_weight', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'pnVendor' => array(self::BELONGS_TO, 'DbVendor', 'pn_vendor'),
			'pnNumber' => array(self::BELONGS_TO, 'DbNumber', 'pn_number'),
			'incomings' => array(self::HAS_MANY, 'DbIncoming', 'in_pn'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'pn_id' => 'id',
			'pn_vendor' => 'Vendor ID',
			'pn_number' => 'Number ID',
			'pn_weight' => 'Weight (kg)',
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('pn_id',$this->pn_id);
		
		if ($this->pn_vendor) {
			$criteria->with[] = 'pnVendor';
			$criteria->compare('upper(v_name)', mb_strtoupper($this->pn_vendor), true);
		}
		
		if ($this->pn_number) {
			$criteria->with[] = 'pnNumber';
			$criteria->compare('upper(n_number)', mb_strtoupper($this->pn_number), true);
		}
		
		$criteria->compare('pn_weight',$this->pn_weight,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getVendorS()
	{
		$ar = DbVendor::model()->findByPk($this->pn_vendor);
		return $ar ? $ar->v_name : "";
	}
	
	public function getNumberS()
	{
		$ar = DbNumber::model()->findByPk($this->pn_number);
		return $ar ? $ar->n_number : "";
	}
	
	protected function beforeSave()
    {
		if (parent::beforeSave()) {
			$this->pn_weight = (new FilteredWeight($this->pn_weight))->value();
			if ($this->pn_weight==="") $this->pn_weight=null;
			
			return true;
		}
        return false;
    }
	
}
