<?php

/**
 * This is the model class for table "shipment_status".
 *
 * The followings are the available columns in table 'shipment_status':
 * @property integer $ss_id
 * @property string $ss_name
 * @property string $ss_description
 */
class ShipmentStatus extends LActiveRecord
{
	public static $list_key_field='ss_id';
	public static $list_name_field='ss_name';
	public static $list_sort_field='ss_id';
	
	const SS_CREATED = 10;
	const SS_OPENED = 20;
	const SS_CLOSED = 30;
	const SS_SENT = 40;
	const SS_INVOICED = 50;

	public function tableName()
	{
		return 'shipment_status';
	}

	public function rules()
	{
		return [
			['ss_name, ss_description', 'safe'],
			['ss_id, ss_name, ss_description', 'safe', 'on'=>'search'],
		];
	}

	public function relations()
	{
		return [
		];
	}

	public function attributeLabels()
	{
		return [
			'ss_id' => 'id',
			'ss_name' => 'Name',
			'ss_description' => 'Description',
		];
	}

	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('ss_id',$this->ss_id);
		$criteria->compare('lower(ss_name)',mb_strtolower($this->ss_name),true);
		$criteria->compare('lower(ss_description)',mb_strtolower($this->ss_description),true);

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
		return $this->ss_id;
	}
	
	public function getName()
	{
		return $this->ss_name;
	}
	
	public function getDescription()
	{
		return $this->ss_description;
	}
	
}
