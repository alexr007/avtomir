<?php

/**
 * This is the model class for table "shipment_items".
 *
 * The followings are the available columns in table 'shipment_items':
 * @property integer $si_id
 * @property integer $si_shipment
 * @property integer $si_item
 * @property string $si_date
 * @property integer $si_user
 *
 * The followings are the available model relations:
 * @property Shipment $siShipment
 * @property Pallet $siItem
 */
class ShipmentItems extends CActiveRecord
{
	const ERR_SUCCESS = 'success';
	const ERR_NOTICE = 'notice';
	const ERR_ERROR = 'error';
	
	private $_error_code; // success | error | notice
	private $_error_message;
	
	public function tableName()
	{
		return 'shipment_items';
	}

	public function rules()
	{
		return [
			['si_shipment, si_item, si_date, si_user', 'safe'],
			['si_id, si_shipment, si_item, si_date, si_user', 'safe', 'on'=>'search'],
		];
	}

	public function relations()
	{
		return [
			'siShipment' => [self::BELONGS_TO, 'Shipment', 'si_shipment'],
			'siItem' => [self::BELONGS_TO, 'Pallet', 'si_item'],
		];
	}

	public function attributeLabels()
	{
		return [
			'si_id' => 'Si',
			'si_shipment' => 'Si Shipment',
			'si_item' => 'Si Item',
			'si_date' => 'Si Date',
			'si_user' => 'Si User',
		];
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('si_id',$this->si_id);
		$criteria->compare('si_shipment',$this->si_shipment);
		$criteria->compare('si_item',$this->si_item);
		$criteria->compare('si_date',$this->si_date,true);
		$criteria->compare('si_user',$this->si_user);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function defaultScope() 
	{
		return [
			'order'=>'si_date desc',
		];
	}
	
	// scope
	public function byShipment($shipment = null)
	{
		if ($shipment === null) 
			$this->getDbCriteria()->mergeWith([
				'condition'=>'1=2',
			]);
		else
			$this->getDbCriteria()->mergeWith([
				'condition'=>'si_shipment='.(int)$shipment,
			]);
			
		return $this;		
	}
	
	protected function beforeSave()
    {
        if (parent::beforeSave()) {
			$this->si_date = new CDbExpression('NOW()');
			$this->si_user = Yii::app()->user->id;
			return true;
		}
		return false;
    }

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function ___________set_get_______(){}
	
	/// id
	public function setId($value = null)
	{
		$this->si_id=$value;
		return $this;
	}
	
	public function getId()
	{
		return $this->si_id;
	}
	
	/// shipment
	public function setShipment($value = null)
	{
		$this->si_shipment=$value;
		return $this;
	}
	
	public function getShipment()
	{
		return $this->si_shipment;
	}
	
	/// item
	public function setItem($value = null)
	{
		$this->si_item=$value;
		return $this;
	}
	
	public function getItem()
	{
		return $this->si_item;
	}
	
	/// errorCode
	public function setErrorCode($value = null)
	{
		$this->_error_code = $value;
		return $this;
	}
	
	public function getErrorCode()
	{
		return $this->_error_code;
	}
	
	// errorMessage
	public function setErrorMessage($value = null)
	{
		$this->_error_message = $value;
		return $this;
	}
	
	public function getErrorMessage()
	{
		return $this->_error_message;
	}
	
	public function ___________static_______(){}
	
	public static function countInShipment($shipment = null)
	{
		return $shipment === null ? false :
			self::model()->countByAttributes(['si_shipment'=>$shipment]);
	}
	
	public static function weightInShipment($shipment = null)
	{
		if ($shipment === null) return false;
		$si = self::model()->findAllByAttributes(['si_shipment'=>$shipment]);
		if ($si == null) return false;
		
		$sum =0;
		foreach ($si as $item)
			$sum += PalletItems::weightInPallet($item->si_item);
		
		return $sum == null ? '' : number_format($sum, 2);
	}
	
	public static function isEmptyShipment($shipment = null)
	{
		return $shipment === null ? false :
			self::countInShipment($shipment) == 0;
	}
	
	public static function checkItemInShipment($item = null, $shipment = null)
	{
		return
			self::model()->countByAttributes(['si_item'=>$item,'si_shipment'=>$shipment]) > 0;
	}

	public static function getMethodsFromShipment($shipment = null)
	{
		$mq = Yii::app()->db->createCommand()
					->select('pl_method')
					->from('shipment_items')
					->join('pallet','pl_id=si_item')
					->where('si_shipment=:shipment',[':shipment'=>$shipment])
					->group('pl_method')
					->queryAll();

		$m=[];
		
		foreach ($mq as $method)
			$m[]=(int)$method['pl_method'];

		return $m;
	}
	
	public static function findItem($item = null, $asString = false)
	{
		if ($item == null) return false;
		$found = self::model()->findByAttributes(['si_item'=>$item]);
		
		return ($found) ? 
			($asString ? $found->siShipment->number : $found->si_shipment) :
			($asString ? "" : false)  ;
	}
	
	public static function addItemToShipment($item = null, $shipment = null)
	{
		if ($item == null || $shipment == null) return false;
		
		if (self::checkItemInShipment($item, $shipment)) return true; // есть в этой палетте
		if (self::findItem($item)) return false; // есть в другой палетте
		
		$si = new self;
		
		$si->isNewRecord = true;
		$si->item = (int)$item;
		$si->shipment = (int)$shipment;
		
		if (!$si->save()) return false; // ошибка БД
		
		// теперь обновляем статус ПАЛЕТТЫ->КОРОБКИ, которую положили на паллет.
		// return Trackings::model()->findByPk($item)->setScanout()->save(); 
	}
	
	public static function removeItemFromShipment($item = null)
	{
		if ($item === null) return false;
		
		$si = self::model()->findByAttributes(['si_item'=>$item]);
		if (!$si) return false;

		if (!$si->delete()) return false; // ошибка БД;
		
		// теперь обновляем статус ПАЛЕТТЫ->КОРОБКИ, которую положили на паллет.
		// return Trackings::model()->findByPk($item)->setScan()->save(); 
	}
	
	public function getXlLevel1($value = null)
	{
		// $pallet_items
		return PalletItems::model()->findAllByAttributes(['pi_pallet'=>$value]);
	}
	
}
