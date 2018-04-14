<?php

/**
 * This is the model class for table "tariffs".
 *
 * The followings are the available columns in table 'tariffs':
 * @property integer $tf_id
 * @property integer $tf_method
 * @property string $tf_kg
 * @property string $tf_item
 * @property string $tf_dispatch
 * @property string $tf_minitem
 * @property string $tf_mindispatch
 * @property string $tf_operator
 * @property integer $tf_days
 * @property string $tf_comment
 * @property integer $tf_enable
 */
class Tariffs extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tariffs';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tf_method, tf_days, tf_enable', 'numerical', 'integerOnly'=>true),
			array('tf_kg, tf_item, tf_dispatch, tf_minitem, tf_mindispatch', 'length', 'max'=>10),
			array('tf_operator, tf_comment', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('tf_id, tf_method, tf_kg, tf_item, tf_dispatch, tf_minitem, tf_mindispatch, tf_operator, tf_days, tf_comment, tf_enable', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'tfMethod' => array(self::BELONGS_TO, 'Shippingmethods', 'tf_method'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'tf_id' => 'id',
			'tf_operator' => 'Operator',
			'tf_method' => 'Method',
			'tf_kg' => '$/1 kg ',
			'tf_item' => '$/1 item',
			'tf_dispatch' => '$/1 dispatch',
			'tf_minitem' => 'min weight item',
			'tf_mindispatch' => 'min weight dispatch',
			'tf_days' => 'Delivery time (days)',
			'tf_comment' => 'Comment',
			'tf_enable' => 'Enable',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('tf_id',$this->tf_id);
		$criteria->compare('upper(tf_operator)',mb_strtoupper($this->tf_operator),true);
		$criteria->compare('tf_method',$this->tf_method);
		$criteria->compare('tf_kg',$this->tf_kg,true);
		$criteria->compare('tf_item',$this->tf_item,true);
		$criteria->compare('tf_dispatch',$this->tf_dispatch,true);
		$criteria->compare('tf_minitem',$this->tf_minitem,true);
		$criteria->compare('tf_mindispatch',$this->tf_mindispatch,true);
		$criteria->compare('tf_days',$this->tf_days);
		$criteria->compare('tf_comment',$this->tf_comment,true);
		$criteria->compare('tf_enable',$this->tf_enable);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Tariffs the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
