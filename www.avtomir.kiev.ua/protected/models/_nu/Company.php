<?php

/**
 * This is the model class for table "company".
 *
 * The followings are the available columns in table 'company':
 * @property integer $cm_id
 * @property string $cm_name
 * @property string $cm_description
 * @property string $cm_comment
 */
class Company extends LActiveRecord
{
	public static $list_key_field='cm_id';
	public static $list_name_field='cm_name';
	public static $list_sort_field='cm_id';
	
	public function tableName()
	{
		return 'company';
	}

	public function rules()
	{
		return [
			array('cm_name, cm_description, cm_comment', 'safe'),
			array('cm_id, cm_name, cm_description, cm_comment', 'safe', 'on'=>'search'),
		];
	}

	public function relations()
	{
		return [
		];
	}

	public function attributeLabels()
	{
		return array(
			'cm_id' => 'id',
			'cm_name' => 'Name',
			'cm_description' => 'Description',
			'cm_comment' => 'Comment',
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('cm_id',$this->cm_id);
		$criteria->compare('lower(cm_name)',mb_strtolower($this->cm_name),true);
		$criteria->compare('lower(cm_description)',mb_strtolower($this->cm_description),true);
		$criteria->compare('lower(cm_comment)',mb_strtolower($this->cm_comment),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/// id
	public function getId()
	{
		return $this->cm_id;
	}
	
	/// name
	public function getName()
	{
		return $this->cm_name == null ? '' : $this->cm_name;
	}
}
