<?php

/**
 * This is the model class for table "cities".
 *
 * The followings are the available columns in table 'cities':
 * @property integer $ci_id
 * @property string $ci_name
 * @property integer $ci_enable
 * @property integer $ci_country
 */
class Cities extends LActiveRecord
{
	public static $list_key_field='ci_id';
	public static $list_name_field='ci_name';
	public static $list_sort_field='ci_id';
	
	public function tableName()
	{
		return 'cities';
	}

	public function rules()
	{
		return array(
			array('ci_enable, ci_country', 'numerical', 'integerOnly'=>true),
			array('ci_name', 'safe'),
			array('ci_id, ci_name, ci_enable, ci_country', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return [
			'ciCountry' => array(self::BELONGS_TO, 'Countries', 'ci_country'),
		];
	}

	public function attributeLabels()
	{
		return array(
			'ci_id' => 'id',
			'ci_name' => 'Name',
			'ci_country' => 'Country',
			'ci_enable' => 'Enable',
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('ci_id',$this->ci_id);
		$criteria->compare('upper(ci_name)',mb_strtoupper($this->ci_name),true);
		$criteria->compare('ci_enable',$this->ci_enable);
		$criteria->compare('ci_country',$this->ci_country);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
