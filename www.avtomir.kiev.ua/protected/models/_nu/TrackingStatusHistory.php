<?php

class TrackingStatusHistory extends CActiveRecord
{
	public function tableName()
	{
		return 'tracking_status_history';
	}

	public function rules()
	{
		return [
			['sh_track_id, sh_date, sh_status, sh_user', 'safe'],
			['sh_id, sh_track_id, sh_date, sh_status, sh_user', 'safe', 'on'=>'search'],
		];
	}

	public function relations()
	{
		return [
            'shTracking' => [self::BELONGS_TO, 'PalletStatus', 'sh_track_id'],
            'shStatus' => [self::BELONGS_TO, 'TrackingStatus', 'sh_status'],
            'shUser' => [self::BELONGS_TO, 'User', 'sh_user'],
		];
	}

	public function attributeLabels()
	{
		return [
			'sh_id' => 'id',
			'sh_track_id' => 'tracking_id',
			'sh_date' => 'date',
			'sh_status' => 'status',
			'sh_user' => 'user',
		];
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('sh_id',$this->sh_id);
		$criteria->compare('sh_track_id',$this->sh_track_id);
		$criteria->compare('sh_date',$this->sh_date,true);
		$criteria->compare('sh_status',$this->sh_status);
		$criteria->compare('sh_user',$this->sh_user);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public static function findStatusDate($item, $status, $asString = false)
	{
		$ar = static::model()->findByAttributes(['sh_track_id'=>(int)$item,'sh_status'=>(int)$status], ['order'=>'sh_date ASC']);
		return $ar !=null ? 
			(!$asString ? $ar->sh_date : date("d.m.Y", strtotime($ar->sh_date))) : 
			(!$asString ? null : "");
	}
	
	public static function writeItem($track_id = null, $status = null, $user_id = null, $date = null)
	{
		$tsh = new self;
		
		$date = ($date == null) ? new CDbExpression('NOW()') : $date ;
		
		$tsh->isNewRecord = true;
		$tsh->sh_track_id = $track_id;
		$tsh->sh_status = $status;
		$tsh->sh_user = $user_id;
		$tsh->sh_date = $date;
		
		return $tsh->save();
	}
}
