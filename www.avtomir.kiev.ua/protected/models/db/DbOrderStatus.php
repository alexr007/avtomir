<?php

/**
 * This is the model class for table "order_status".
 *
 * The followings are the available columns in table 'order_status':
 * @property integer $os_id
 * @property string $os_name
 */
class DbOrderStatus extends LActiveRecord
{
    public static $list_key_field = 'os_id';	// id;
    public static $list_name_field = 'os_name';	// 'name';
    public static $list_sort_field = 'os_id';	// 'id';

	const OS_CREATED = 1;
	const OS_INPROCESS = 5;
	const OS_DONE = 9;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'order_status';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('os_name', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('os_id, os_name', 'safe', 'on'=>'search'),
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
			'os_id' => 'Os',
			'os_name' => 'Os Name',
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

		$criteria->compare('os_id',$this->os_id);
		$criteria->compare('os_name',$this->os_name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DbOrderStatus the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}