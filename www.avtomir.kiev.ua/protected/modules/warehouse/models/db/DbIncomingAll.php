<?php

class DbIncomingAll extends CActiveRecord
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
		return 'incoming_all';
	}

	public function search()
	{
		$criteria=new CDbCriteria;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getInDateS()
	{
		return (new DateFormatted($this->in_date))->date();
	}
}
