<?php

class Operators extends LActiveRecord
{
	public static $list_key_field='op_id';
	public static $list_name_field='op_name';
	public static $list_sort_field='op_name';
	
	public function tableName()
	{
		return 'operators';
	}

	public function rules()
	{
		return array(
			array('op_country, op_enable', 'numerical', 'integerOnly'=>true),
			array('op_name, op_comment', 'safe'),
			array('op_id, op_name, op_country, op_comment, op_enable', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'opCountry' => array(self::BELONGS_TO, 'Countries', 'op_country'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'op_id' => 'id',
			'op_name' => 'Name',
			'op_country' => 'Country',
			'op_comment' => 'Comment',
			'op_enable' => 'Enable',
		);
	}

	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('op_id',$this->op_id);
		$criteria->compare('op_name',$this->op_name,true);
		$criteria->compare('op_country',$this->op_country);
		$criteria->compare('op_comment',$this->op_comment,true);
		$criteria->compare('op_enable',$this->op_enable);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
    public function scopes()
    {
        return [
            'enabled'=>[
                'condition'=>"op_enable=1",
            ],
        ];
    }
	
	/// id
	public function getId()
	{
		return $this->op_id;
	}
	
	/// name
	public function getName()
	{
		return $this->op_name == null ? '' : $this->op_name;
	}
	
	protected function beforeSave()
    {
		if (parent::beforeSave()) {
			if ($this->op_country == 0) $this->op_country=NULL;
			
			return true;
		}
        return false;
    }
}
