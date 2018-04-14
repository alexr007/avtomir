<?php

/**
 * This is the model class for table "warehouse_stock_price".
 *
 * The followings are the available columns in table 'warehouse_stock_price':
 * @property integer $in_link
 * @property integer $in_pn
 * @property string $v_name
 * @property string $n_number
 * @property string $sum
 * @property string $in_price
 */
class DbWarehouseStockPrice extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'warehouse_stock_price';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('in_link, in_pn', 'numerical', 'integerOnly'=>true),
			array('in_price', 'length', 'max'=>8),
			array('v_name, n_number, sum', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('in_link, in_pn, v_name, n_number, sum, in_price', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'in_link' => 'In Link',
			'in_pn' => 'In Pn',
			'v_name' => 'V Name',
			'n_number' => 'N Number',
			'sum' => 'Sum',
			'in_price' => 'In Price',
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

		$criteria->compare('in_link',$this->in_link);
		$criteria->compare('in_pn',$this->in_pn);
		$criteria->compare('v_name',$this->v_name,true);
		$criteria->compare('n_number',$this->n_number,true);
		$criteria->compare('sum',$this->sum,true);
		$criteria->compare('in_price',$this->in_price,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DbWarehouseStockPrice the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
