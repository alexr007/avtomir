<?php

class DbVendor extends LActiveRecord
{
	public static $list_key_field = 'v_id';	// id;
	public static $list_name_field = 'v_name';	// 'name';
	public static $list_sort_field = 'v_name';	// 'id';
	
//    public function getDbConnection()
//	{
//        return Yii::app()->db2;
//    }

	public function tableName()
	{
		return 'vendors';
	}

	public function rules()
	{
		return array(
			array('v_id, v_name', 'safe'),
			array('v_id, v_name', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'partNumbers' => array(self::HAS_MANY, 'DbPartNumber', 'pn_vendor'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'v_id' => 'id',
			'v_name' => 'Name',
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('v_id',$this->v_id);
		$criteria->compare('v_name',$this->v_name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
}
