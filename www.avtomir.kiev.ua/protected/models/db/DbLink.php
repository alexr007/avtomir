<?php

class DbLink extends CActiveRecord
{
	public function tableName()
	{
		return 'link';
	}

	public function rules()
	{
		return array(
			array('ln_name, ln_url', 'safe'),
			array('ln_id, ln_name, ln_url', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return [];
	}

	public function attributeLabels()
	{
		return [
			'ln_id' => 'id',
			'ln_name' => 'Link Name',
			'ln_url' => 'Link URL',
		];
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('ln_id',$this->ln_id);
		$criteria->compare('upper(ln_name)',  mb_strtoupper($this->ln_name),true);
		$criteria->compare('upper(ln_url)',  mb_strtoupper($this->ln_url),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function url() {
		return $this->ln_url;
	}
	
}
