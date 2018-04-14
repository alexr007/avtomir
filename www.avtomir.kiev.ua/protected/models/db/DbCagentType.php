<?php

class DbCagentType extends LActiveRecord
{
	public static $list_key_field = 'ct_id';	// id;
	public static $list_name_field = 'ct_name';	// 'name';
	public static $list_sort_field = 'ct_id';	// 'id';
	
	public function tableName()
	{
		return 'cagent_type';
	}

	public function rules()
	{
		return array(
			array('ct_id, ct_name', 'safe'),
			array('ct_id, ct_name', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'cagents' => array(self::HAS_MANY, 'DbCagent', 'ca_type'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'ct_id' => 'Ct',
			'ct_name' => 'Ct Name',
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('ct_id',$this->ct_id);
		$criteria->compare('ct_name',$this->ct_name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getId() {
		return $this->ct_id;
	}
	
	public function getName() {
		return $this->ct_name;
	}
}
