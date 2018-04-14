<?php

/**
 * This is the model class for table "order_item_status".
 *
 * The followings are the available columns in table 'order_item_status':
 * @property integer $ois_id
 * @property string $ois_name
 */
class DbOrderItemStatus extends LActiveRecord
{
    public static $list_key_field = "ois_id";	// id;
    public static $list_name_field = "ois_name";	// 'name';
    public static $list_sort_field = "ois_id";	// 'id';

    const OIS_NEW = 1;
    const OIS_RECEIVED = 10;
    const OIS_PAUSED = 20;
    const OIS_ORDERED = 30;
    const OIS_BOUGHT = 40;
    const OIS_DELIVERY = 50;
    const OIS_READY = 60;
    const OIS_FINISHED = 70;
    const OIS_CANCELLED = 80;


	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'order_item_status';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ois_name', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ois_id, ois_name', 'safe', 'on'=>'search'),
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
			'ois_id' => 'Ois',
			'ois_name' => 'Ois Name',
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

		$criteria->compare('ois_id',$this->ois_id);
		$criteria->compare('ois_name',$this->ois_name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DbOrderItemStatus the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
