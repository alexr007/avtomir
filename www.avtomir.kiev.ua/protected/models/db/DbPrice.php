<?php

/**
 * This is the model class for table "price".
 *
 * The followings are the available columns in table 'price':
 * @property integer $pr_id
 * @property integer $pr_vendor
 * @property string $pr_date
 * @property string $pr_number
 * @property string $pr_name
 * @property string $pr_price
 * @property string $pr_weight
 * @property integer $pr_dealer
 * @property string $pr_core
 *
 * The followings are the available model relations:
 * @property Dealer $prDealer
 * @property Vendors $prVendor
 */
class DbPrice extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'price';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pr_vendor, pr_dealer', 'numerical', 'integerOnly'=>true),
			array('pr_price, pr_weight, pr_core', 'length', 'max'=>10),
			array('pr_date, pr_number, pr_name', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('pr_id, pr_vendor, pr_date, pr_number, pr_name, pr_price, pr_weight, pr_dealer, pr_core', 'safe', 'on'=>'search'),
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
			'prDealer' => array(self::BELONGS_TO, 'DbDealer', 'pr_dealer'),
			'prVendor' => array(self::BELONGS_TO, 'DbVendor', 'pr_vendor'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pr_id' => 'Pr',
			'pr_vendor' => 'Pr Vendor',
			'pr_date' => 'Pr Date',
			'pr_number' => 'Pr Number',
			'pr_name' => 'Pr Name',
			'pr_price' => 'Pr Price',
			'pr_weight' => 'Pr Weight',
			'pr_dealer' => 'Pr Dealer',
			'pr_core' => 'Pr Core',
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

		$criteria->compare('pr_id',$this->pr_id);
		$criteria->compare('pr_vendor',$this->pr_vendor);
		$criteria->compare('pr_date',$this->pr_date,true);
		$criteria->compare('pr_number',$this->pr_number,true);
		$criteria->compare('pr_name',$this->pr_name,true);
		$criteria->compare('pr_price',$this->pr_price,true);
		$criteria->compare('pr_weight',$this->pr_weight,true);
		$criteria->compare('pr_dealer',$this->pr_dealer);
		$criteria->compare('pr_core',$this->pr_core,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DbPrice the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
