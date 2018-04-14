<?php

/**
 * This is the model class for table "tracking_status".
 *
 * The followings are the available columns in table 'tracking_status':
 * @property integer $ts_id
 * @property string $ts_name
 *
 * The followings are the available model relations:
 * @property Trackings[] $trackings
 */
class TrackingStatus extends LActiveRecord
{
	public static $list_key_field='ts_id';
	public static $list_name_field='ts_name';
	public static $list_sort_field='ts_id';
	
	const TS_ENTERED = 10;
	const TS_SCAN = 20;
	const TS_SCANOUT = 40;
	const TS_SENT = 50;
	const TS_REJECT = 60;

	public function tableName()
	{
		return 'tracking_status';
	}

	public function rules()
	{
		return array(
			array('ts_name, ts_description','safe'),
			array('ts_id, ts_name, ts_description', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return [
			'trackings' => array(self::HAS_MANY, 'Trackings', 'tr_status'),
		];
	}

	public function attributeLabels()
	{
		return array(
			'ts_id' => 'id',
			'ts_name' => 'Status Name',
			'ts_description' => 'Status Description',
		);
	}

	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('ts_id',$this->ts_id);
		$criteria->compare('upper(ts_name)',mb_strtoupper($this->ts_name),true);
		$criteria->compare('upper(ts_description)',mb_strtoupper($this->ts_description),true);

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
		return $this->ts_id;
	}
	
	public function getName()
	{
		return $this->ts_name;
	}
	
	public function getDescription()
	{
		return $this->ts_description;
	}
}