<?php

/**
 * This is the model class for table "dealer".
 *
 * The followings are the available columns in table 'dealer':
 * @property integer $dl_id
 * @property string $dl_name
 * @property integer $dl_country
 * @property string $dl_comment
 * @property string $dl_showas
 * @property integer $dl_enabled
 *
 * The followings are the available model relations:
 * @property Cart[] $carts
 */
class DbDealer extends LActiveRecord
{
    public static $list_key_field = "dl_id";	// id;
    public static $list_name_field = "dl_name";	// 'name';
    public static $list_sort_field = "dl_id";	// 'id';
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dealer';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('dl_id, dl_name, dl_country, dl_comment, dl_showas, dl_enabled', 'safe'),
			array('dl_id, dl_name, dl_country, dl_comment, dl_showas, dl_enabled', 'safe', 'on'=>'search'),
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
			'carts' => array(self::HAS_MANY, 'Cart', 'ct_dealer'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'dl_id' => 'Dl',
			'dl_name' => 'Dl Name',
			'dl_country' => 'Dl Country',
			'dl_comment' => 'Dl Comment',
			'dl_showas' => 'Dl Showas',
			'dl_enabled' => 'Dl Enabled',
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('dl_id',$this->dl_id);
		$criteria->compare('dl_name',$this->dl_name,true);
		$criteria->compare('dl_country',$this->dl_country);
		$criteria->compare('dl_comment',$this->dl_comment,true);
		$criteria->compare('dl_showas',$this->dl_showas,true);
		$criteria->compare('dl_enabled',$this->dl_enabled);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getId()
	{
		return $this->dl_id;
	}
	
	public function getName()
	{
		return $this->dl_name;
	}
	
	public function getShowAs()
	{
		return $this->dl_showas;
	}
}
