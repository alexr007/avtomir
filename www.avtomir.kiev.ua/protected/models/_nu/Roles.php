<?php

class Roles extends CActiveRecord
{
	public function tableName()
	{
		return 'roles';
	}

	public function rules()
	{
		return array(
			array('rl_role, rl_desc', 'safe'),
			array('rl_id, rl_role, rl_desc', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
		);
	}

	public function attributeLabels()
	{
		return array(
			'rl_id' => 'id',
			'rl_role' => 'Role',
			'rl_desc' => 'Description',
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('rl_id',$this->rl_id);
		$criteria->compare('lower(rl_role)',mb_strtolower($this->rl_role),true);
		$criteria->compare('lower(rl_desc)',mb_strtolower($this->rl_desc),true);

		return new CActiveDataProvider($this, [
			'criteria'=>$criteria,
		]);
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
