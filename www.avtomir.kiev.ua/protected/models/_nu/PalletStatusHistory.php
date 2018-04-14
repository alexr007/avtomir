<?php

class PalletStatusHistory extends CActiveRecord
{
	public function tableName()
	{
		return 'pallet_status_history';
	}

	public function rules()
	{
		return [
			['psh_pallet, psh_date, psh_status, psh_user', 'safe'],
			['psh_id, psh_pallet, psh_date, psh_status, psh_user', 'safe', 'on'=>'search'],
		];
	}

	public function relations()
	{
        return [
            'pshPallet' => [self::BELONGS_TO, 'Pallet', 'psh_pallet'],
            'pshStatus' => [self::BELONGS_TO, 'PalletStatus', 'psh_status'],
            'pshUser' => [self::BELONGS_TO, 'User', 'psh_user'],
        ];
	}	

	public function attributeLabels()
	{
		return [
			'psh_id' => 'id',
			'psh_pallet' => 'Pallet_id',
			'psh_date' => 'Date',
			'psh_status' => 'Status',
			'psh_user' => 'User',
		];
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('psh_id',$this->psh_id);
		$criteria->compare('psh_pallet',$this->psh_pallet);
		$criteria->compare('psh_date',$this->psh_date,true);
		$criteria->compare('psh_status',$this->psh_status);
		$criteria->compare('psh_user',$this->psh_user);

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
		$ar = static::model()->findByAttributes(['psh_pallet'=>(int)$item,'psh_status'=>(int)$status], ['order'=>'psh_date ASC']);
		return $ar !=null ? 
			(!$asString ? $ar->psh_date : date("d.m.Y", strtotime($ar->psh_date))) : 
			(!$asString ? null : "");
	}
	
	public static function writeItem($item = null, $status = null, $user_id = null, $date = null)
	{
		$psh = new self;
		
		$date = ($date == null) ? new CDbExpression('NOW()') : $date ;
		
		$psh->isNewRecord = true;
		$psh->psh_pallet = $item;
		$psh->psh_status = $status;
		$psh->psh_user = $user_id;
		$psh->psh_date = $date;
		
		return $psh->save();
	}
	
	// текущий статус из истории
	public static function getStatus($item = null, $asString = false)
	{
		if ($item != null)
			$st = static::model()->findByAttributes(['psh_pallet'=>(int)$item], ['order'=>'psh_date DESC']);

		return $st == null ?
			($asString ? "" : null):
			($asString ? $st->pshStatus->name : $st->psh_status);
	}
}

?>