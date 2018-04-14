<?php

/**
 * This is the model class for table "address".
 *
 * The followings are the available columns in table 'address':
 * @property integer $ad_id
 * @property string $ad_address
 * @property string $ad_nick
 * @property string $ad_key
 * @property integer $ad_country
 *
 * The followings are the available model relations:
 * @property Countries $adCountry
 */
class Address extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'address';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ad_country', 'numerical', 'integerOnly'=>true),
			array('ad_address, ad_nick, ad_key', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ad_id, ad_address, ad_nick, ad_key, ad_country', 'safe', 'on'=>'search'),
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
			'adCountry' => array(self::BELONGS_TO, 'Countries', 'ad_country'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ad_id' => 'id',
			'ad_address' => 'Address',
			'ad_nick' => 'Nick',
			'ad_key' => 'Key',
			'ad_country' => 'Country',
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

		$criteria->compare('ad_id',$this->ad_id);
		$criteria->compare('ad_address',$this->ad_address,true);
		$criteria->compare('ad_nick',$this->ad_nick,true);
		$criteria->compare('ad_key',$this->ad_key,true);
		$criteria->compare('ad_country',$this->ad_country);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Address the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
    public function scopes()
    {
		
		return [
            'enabled'=>[
				'condition'=>"ad_enable=1"
				],
        ];
    }
	
	public static function getAddress()
	{
		$a = Address::model()->enabled()->findAll();
		if ($a === null) return false;
			else return $a;
	}
}
