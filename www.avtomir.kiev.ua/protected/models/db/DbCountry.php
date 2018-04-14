<?php

/**
 * This is the model class for table "countries".
 *
 * The followings are the available columns in table 'countries':
 * @property integer $co_id
 * @property string $co_name
 * @property string $co_sname
 */
class DbCountry extends LActiveRecord
{
	public static $list_key_field='co_id';
	public static $list_name_field='co_name';
	public static $list_sort_field='co_id';
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'country';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('co_name, co_sname', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('co_id, co_name, co_sname', 'safe', 'on'=>'search'),
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
			'dealers' => array(self::HAS_MANY, 'Dealers', 'dl_country'),
			'stores' => array(self::HAS_MANY, 'Stores', 'st_country'),
			'addresses' => array(self::HAS_MANY, 'Address', 'ad_country'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'co_id' => 'Country ID',
			'co_name' => 'Country Full name',
			'co_sname' => 'Country Short name',
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

		$criteria->compare('co_id',$this->co_id);
		$criteria->compare('upper(co_name)',mb_strtoupper($this->co_name),true);
		$criteria->compare('upper(co_sname)',mb_strtoupper($this->co_sname),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Countries the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/// id
	public function getId()
	{
		return $this->co_id;
	}
	
	/// name
	public function getName()
	{
		return $this->co_name == null ? '' : $this->co_name;
	}
	
}
