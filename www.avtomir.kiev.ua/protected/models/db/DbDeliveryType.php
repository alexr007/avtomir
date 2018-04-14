<?php

class DbDeliveryType extends LActiveRecord
{
	
	public static $list_key_field = 'dt_id';	// id;
	public static $list_name_field = 'dt_name';	// 'name';
	public static $list_sort_field = 'dt_id';	// 'id';
	
	public function tableName()
	{
		return 'delivery_type';
	}

	public function rules()
	{
		return [
			['dt_id, dt_name', 'safe'],
			['dt_id, dt_name', 'safe', 'on'=>'search'],
		];
	}

	public function relations()
	{
		return [];
	}

	public function attributeLabels()
	{
		return array(
			'dt_id' => 'id',
			'dt_name' => 'Name',
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('dt_id',$this->dt_id);
		$criteria->compare('dt_name',$this->dt_name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getId()
	{
		return $this->dt_id;
	}
	
	public function getName()
	{
		return $this->dt_name;
	}
}
