<?php

class DbNumber extends LActiveRecord
{
	public static $list_key_field = 'n_id';	// id;
	public static $list_name_field = 'n_number';	// 'name';
	public static $list_sort_field = 'n_id';	// 'id';
	
    /*
	public function getDbConnection()
	{
        return Yii::app()->db2;
    }
	 * 
	 */

	public function tableName()
	{
		return 'numbers';
	}

	public function rules()
	{
		return array(
			array('n_id, n_number', 'safe'),
			array('n_id, n_number', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'partNumbers' => array(self::HAS_MANY, 'DbPartNumber', 'pn_number'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'n_id' => 'id',
			'n_number' => 'Number',
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('n_id',$this->n_id);
		$criteria->compare('n_number',$this->n_number,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
