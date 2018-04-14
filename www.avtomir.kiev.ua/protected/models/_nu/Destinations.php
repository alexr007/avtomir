<?php

class Destinations extends LActiveRecord
{
	public static $list_key_field='ds_id';
	public static $list_name_field='ds_name';
	public static $list_sort_field='ds_name';
	
	public function tableName()
	{
		return 'destination';
	}

	public function attributeLabels()
	{
		return array(
			'ds_id' => 'Destination ID',
			'ds_name' => 'Destination Name',
		);
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/// id
	public function getId()
	{
		return $this->ds_id;
	}
	
	/// name
	public function getName()
	{
		return $this->ds_name == null ? '' : $this->ds_name;
	}
	
	public function findByPk($pk,$condition='',$params=array())
	{
		return $this->findByAttributes(['ds_id'=>$pk],$condition,$params);
	}
}
