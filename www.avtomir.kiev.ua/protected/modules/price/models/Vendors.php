<?php

/**
 * This is the model class for table "vendors".
 *
 * The followings are the available columns in table 'vendors':
 * @property integer $ve_id
 * @property string $ve_name
 * @property integer $ve_sort
 * @property integer $ve_show
 */
class Vendors extends CActiveRecord
{
	public function tableName()
	{
		return 'vendors';
	}

	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return [
			array('ve_id', 'required'),
			array('ve_id, ve_sort, ve_show', 'numerical', 'integerOnly'=>true),
			array('ve_name', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ve_id, ve_name, ve_sort, ve_show', 'safe', 'on'=>'search'),
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
			've_id' => 'id',
			've_name' => 'Name',
			've_sort' => 'sort',
			've_show' => 'show',
		];
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('ve_id',$this->ve_id);
		$criteria->compare('lower(ve_name)',mb_strtolower($this->ve_name),true);
		$criteria->compare('ve_sort',$this->ve_sort);
		$criteria->compare('ve_show',$this->ve_show);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>['pageSize'=>25],
		));
	}
	
	public function defaultScope() {
		
		return [
			'order'=>'ve_sort asc',
//			'limit' => 10,
		];
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
