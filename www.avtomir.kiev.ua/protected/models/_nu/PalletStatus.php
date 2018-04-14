<?php

/**
 * This is the model class for table "pallet_status".
 *
 * The followings are the available columns in table 'pallet_status':
 * @property integer $ps_id
 * @property string $ps_name
 * @property string $ps_description
 */
class PalletStatus extends LActiveRecord
{
	public static $list_key_field='ps_id';
	public static $list_name_field='ps_name';
	public static $list_sort_field='ps_id';
	
	const PS_CREATED = 10;
	const PS_OPENED = 20;
	const PS_CLOSED = 30;
	const PS_SENT = 40;
	
	public function tableName()
	{
		return 'pallet_status';
	}

	public function rules()
	{
		return [
			['ps_id, ps_name, ps_description', 'safe'],
			['ps_id, ps_name, ps_description', 'safe', 'on'=>'search'],
		];
	}

	public function relations()
	{
		return [
			'pallets' => array(self::HAS_MANY, 'Pallet', 'pl_status'),
		];
	}

	public function attributeLabels()
	{
		return [
			'ps_id' => 'id',
			'ps_name' => 'Name',
			'ps_description' => 'Description',
		];
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('ps_id',$this->ps_id);
		$criteria->compare('lower(ps_name)',mb_strtolower($this->ps_name),true);
		$criteria->compare('lower(ps_description)',mb_strtolower($this->ps_description),true);

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
		return $this->ps_id;
	}
	
	public function getName()
	{
		return $this->ps_name;
	}
	
	public function getDescription()
	{
		return $this->ps_description;
	}
}