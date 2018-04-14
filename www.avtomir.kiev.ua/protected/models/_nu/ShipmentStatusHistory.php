<?php

class ShipmentStatusHistory extends CActiveRecord
{
	public function tableName()
	{
		return 'shipment_status_history';
	}

	public function rules()
	{
		return [
			['ssh_shipment, ssh_date, ssh_status, ssh_user', 'safe'],
			['ssh_id, ssh_shipment, ssh_date, ssh_status, ssh_user', 'safe', 'on'=>'search'],
		];
	}

	public function relations()
	{
		return [
			'sshShipment' => [self::BELONGS_TO, 'Shipment', 'ssh_shipment'],
			'sshStatus' => [self::BELONGS_TO, 'ShipmentStatus', 'ssh_status'],
			'sshUser' => [self::BELONGS_TO, 'Users', 'ssh_user'],
		];
	}

	public function attributeLabels()
	{
		return [
			'ssh_id' => 'id',
			'ssh_shipment' => 'Shipment',
			'ssh_date' => 'Date',
			'ssh_status' => 'Status',
			'ssh_user' => 'User',
		];
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('ssh_id',$this->ssh_id);
		$criteria->compare('ssh_shipment',$this->ssh_shipment);
		$criteria->compare('ssh_date',$this->ssh_date,true);
		$criteria->compare('ssh_status',$this->ssh_status);
		$criteria->compare('ssh_user',$this->ssh_user);

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
		$ar = static::model()->findByAttributes(['ssh_shipment'=>(int)$item,'ssh_status'=>(int)$status], ['order'=>'ssh_date ASC']);
		return $ar !=null ? 
			(!$asString ? $ar->ssh_date : date("d.m.Y", strtotime($ar->ssh_date))) : 
			(!$asString ? null : "");
	}
	
	public static function writeItem($item = null, $status = null, $user_id = null, $date = null)
	{
		
		$ssh = new self;
		
		$date = ($date == null) ? new CDbExpression('NOW()') : $date ;
		
		$ssh->isNewRecord = true;
		$ssh->ssh_shipment = $item;
		$ssh->ssh_status = $status;
		$ssh->ssh_user = $user_id;
		$ssh->ssh_date = $date;
			
		return $ssh->save();
	}
	
	// текущий статус из истории
	public static function getStatus($item = null, $asString = false)
	{
		if ($item != null)
			$st = static::model()->findByAttributes(['ssh_shipment'=>(int)$item], ['order'=>'ssh_date DESC']);

		return $st == null ?
			($asString ? "" : null):
			($asString ? $st->sshStatus->name : $st->ssh_status);
	}
}