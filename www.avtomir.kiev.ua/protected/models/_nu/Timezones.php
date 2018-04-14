<?php

class Timezones extends LActiveRecord
{
	public static $list_key_field='tz_id';
	public static $list_name_field='tz_name';
	public static $list_sort_field='tz_id';
	
	public function tableName()
	{
		return 'timezones';
	}

	public function attributeLabels()
	{
		return array(
			'tz_id' => 'id',
			'tz_name' => 'name',
		);
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/// id
	public function getId()
	{
		return $this->tz_id;
	}
	
	/// name
	public function getName()
	{
		return $this->tz_name == null ? '' : $this->tz_name;
	}
	
	public function findByPk($pk,$condition='',$params=array())
	{
		return $this->findByAttributes(['tz_id'=>$pk],$condition,$params);
	}
}
