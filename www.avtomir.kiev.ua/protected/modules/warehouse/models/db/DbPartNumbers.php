<?php

class DbPartNumbers extends CActiveRecord
{
    public function primaryKey()
	{
        return 'pn_id';
    }

//    public function getDbConnection()
//	{
//        return Yii::app()->db2;
//    }

	public function tableName()
	{
		return 'part_numbers';
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getFullNameS()
	{
		return $this->v_name." ".$this->n_number;
	}
}
