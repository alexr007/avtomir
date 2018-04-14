<?php

class DbParameter extends CActiveRecord
{
	
	public function tableName()
	{
		return 'parameter';
	}

	public function rules()
	{
		return array(
			array('pa_id, pa_type, pa_key, pa_value, pa_desc, pa_category', 'safe'),
			array('pa_id, pa_type, pa_key, pa_value, pa_desc, pa_category', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return [];
	}

	public function attributeLabels()
	{
		return array(
			'pa_id' => 'id',
			'pa_type' => 'Type',
			'pa_key' => 'Key',
			'pa_value' => 'Value',
			'pa_desc' => 'Description',
			'pa_category' => 'Category',
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('pa_id',$this->pa_id);
		$criteria->compare('upper(pa_type)', mb_strtoupper($this->pa_type),true);
		$criteria->compare('upper(pa_key)', mb_strtoupper($this->pa_key),true);
		$criteria->compare('upper(pa_value)', mb_strtoupper($this->pa_value),true);
		$criteria->compare('upper(pa_desc)', mb_strtoupper($this->pa_desc),true);
		$criteria->compare('upper(pa_category)', mb_strtoupper($this->pa_category),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
