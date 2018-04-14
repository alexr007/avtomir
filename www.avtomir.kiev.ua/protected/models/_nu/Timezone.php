<?php

/**
 * This is the model class for table "timezone".
 *
 * The followings are the available columns in table 'timezone':
 * @property integer $tz_id
 * @property string $tz_name
 * @property string $tz_shift
 */
class Timezone extends CActiveRecord
{
	public function tableName()
	{
		return 'timezone';
	}

	public function rules()
	{
		return [
			array('tz_name, tz_shift', 'safe'),
			array('tz_id, tz_name, tz_shift', 'safe', 'on'=>'search'),
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
			'tz_id' => 'id',
			'tz_name' => 'Name',
			'tz_shift' => 'Time Shift',
		];
	}

	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('tz_id',$this->tz_id);
		$criteria->compare('tz_name',$this->tz_name,true);
		$criteria->compare('tz_shift',$this->tz_shift,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
