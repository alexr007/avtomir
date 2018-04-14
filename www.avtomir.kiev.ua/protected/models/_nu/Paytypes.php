<?php

/**
 * This is the model class for table "paytypes".
 *
 * The followings are the available columns in table 'paytypes':
 * @property integer $pt_id
 * @property string $pt_name
 * @property integer $pt_cash
 * @property integer $pt_currency
 * @property integer $pt_enable
 *
 * The followings are the available model relations:
 * @property Currency $ptCurrency
 */
class Paytypes extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'paytypes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return [
			['pt_cash, pt_currency, pt_enable', 'numerical', 'integerOnly'=>true],
			['pt_name', 'safe'],
			['pt_cash, pt_enable', 'in', 'range'=>[0, 1], 'message'=>'allowed 0 and 1 only'],
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			['pt_id, pt_name, pt_cash, pt_currency, pt_enable', 'safe', 'on'=>'search'],
			
		];
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'ptCurrency' => array(self::BELONGS_TO, 'Currency', 'pt_currency'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pt_id' => 'id',
			'pt_name' => 'Payment Type Name',
			'pt_cash' => 'cash',
			'pt_currency' => 'Currency',
			'cu_name' => 'Currency NAME',
			'pt_enable' => 'Enable',
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

		$criteria->compare('pt_id',$this->pt_id);
		$criteria->compare('upper(pt_name)',mb_strtoupper($this->pt_name),true);
		$criteria->compare('pt_cash',$this->pt_cash);
		$criteria->compare('pt_currency',$this->pt_currency);
		$criteria->compare('pt_enable',$this->pt_enable);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>['pageSize'=>20],
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Paytypes the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
