<?php

/**
 * This is the model class for table "dealer_log".
 *
 * The followings are the available columns in table 'dealer_log':
 * @property integer $dl_id
 * @property string $dl_date
 * @property integer $dl_dealer
 * @property integer $dl_status
 * @property integer $dl_type
 *
 * The followings are the available model relations:
 * @property DbDealer $dlDealer
 */
class DbDealerLog extends CActiveRecord
{
	public function tableName()
	{
		return 'dealer_log';
	}

	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'dlDealer' => array(self::BELONGS_TO, 'DbDealer', 'dl_dealer'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'dl_id' => 'id',
			'dl_date' => 'Date',
			'dl_dealer' => 'Dealer',
			'dl_status' => 'Status',
            'dl_type' => 'Req Type',
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('dl_id',$this->dl_id);
		$criteria->compare('dl_date',$this->dl_date,true);
		$criteria->compare('dl_dealer',$this->dl_dealer);
		$criteria->compare('dl_status',$this->dl_status);
        $criteria->compare('dl_type',$this->dl_type);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
