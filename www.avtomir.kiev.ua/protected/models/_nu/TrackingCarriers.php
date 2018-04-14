<?php

/**
 * This is the model class for table "tracking_carriers".
 *
 * The followings are the available columns in table 'tracking_carriers':
 * @property integer $tc_id
 * @property string $tc_name
 * @property string $tc_www
 * @property string $tc_trackurl
 *
 * The followings are the available model relations:
 * @property Trackings[] $trackings
 */
class TrackingCarriers extends LActiveRecord
{
	public static $list_key_field='tc_id';
	public static $list_name_field='tc_name';
	public static $list_sort_field='tc_id';
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tracking_carriers';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tc_name, tc_www, tc_trackurl', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('tc_id, tc_name, tc_www, tc_trackurl', 'safe', 'on'=>'search'),
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
			'trackings' => array(self::HAS_MANY, 'Trackings', 'tr_carrier'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'tc_id' => 'id',
			'tc_name' => 'Name',
			'tc_www' => 'www',
			'tc_trackurl' => 'Track URL',
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

		$criteria->compare('tc_id',$this->tc_id);
		$criteria->compare('lower(tc_name)',mb_strtolower($this->tc_name),true);
		$criteria->compare('lower(tc_www)',mb_strtolower($this->tc_www),true);
		$criteria->compare('lower(tc_trackurl)',mb_strtolower($this->tc_trackurl),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TrackingCarriers the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/// trackUrl
	public function getTrackUrl()
	{
		return $this->tc_trackurl != null ? $this->tc_trackurl : "";
	}	
}
