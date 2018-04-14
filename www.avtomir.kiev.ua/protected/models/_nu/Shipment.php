<?php

/**
 * This is the model class for table "shipment".
 *
 * The followings are the available columns in table 'shipment':
 * @property integer $sh_id
 * @property string $sh_number
 * @property integer $sh_route
 * @property string $sh_comment
 *
 * The followings are the available model relations:
 * @property Operators $shRoute
 * @property ShipmentItems[] $shipmentItems
 */
class Shipment extends LActiveRecord
{
	private $_statusChanged;
	private $_current_user_id;
	
	public static $list_key_field='sh_id';
	public static $list_name_field='sh_name';
	public static $list_sort_field='sh_id';
	
	const SHIPMENT_NAME_PREFIX = 'AMTS';
	const SHIPMENT_NAME_POSTFIX = '';
	
	public function tableName()
	{
		return 'shipment';
	}

	public function rules()
	{
		return [
			['sh_number, sh_route, sh_comment, comment, sh_status', 'safe'],
			['status, method, methods', 'safe'],
			['sh_id, sh_number, sh_route, sh_comment, sh_status', 'safe', 'on'=>'search'],
		];
	}

	public function init()
	{
		parent::init();
		$this->_statusChanged = false;
		$this->_current_user_id = Yii::app()->user->id;
	}
	
	public function relations()
	{
		return [
			'shRoute' => [self::BELONGS_TO, 'Operators', 'sh_route'],
			'shStatus' => [self::BELONGS_TO, 'ShipmentStatus', 'sh_status'],
			'shipmentItems' => [self::HAS_MANY, 'ShipmentItems', 'si_shipment'],
			'shipmentStatusHistories' => [self::HAS_MANY, 'ShipmentStatusHistory', 'ssh_shipment'],
			
		];
	}

	public function attributeLabels()
	{
		return array(
			'sh_id' => 'id',
			'sh_number' => 'Number',
			'sh_route' => 'Route (Operator)',
			'sh_comment' => 'Comment',
			'sh_method' => 'Method',
			'sh_status' => 'Status',
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('sh_id',$this->sh_id);
		$criteria->compare('sh_number',$this->sh_number,true);
		$criteria->compare('sh_route',$this->sh_route);
		$criteria->compare('sh_comment',$this->sh_comment,true);
		$criteria->compare('sh_method',$this->sh_method,true);
		$criteria->compare('sh_status',$this->sh_status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
    public function scopes()
    {
		$opened=ShipmentStatus::SS_OPENED;
		$closed=ShipmentStatus::SS_CLOSED;
		$invoiced=ShipmentStatus::SS_INVOICED;
		
		return [
            'opened'=>[
					'condition'=>"sh_status=$opened"
				],
            'closed'=>[
					'condition'=>"sh_status=$closed"
				],
            'invoiced'=>[
					'condition'=>"sh_status=$invoiced"
				],
            'notinvoiced'=>[
					'condition'=>"sh_status<>$invoiced"
				],
        ];
    }
	
	public function behaviors() {
		return [
			'ExportExcelBehavior' => [
				'class' => 'application.components.behavior.CExportExcelBehavior',
			],
		];
	}
	
	public function ___________set_get_______(){}
	
	/// id
	public function getId()
	{
		return (int)$this->sh_id;
	}
	
	public function setId($value = null)
	{
		$this->sh_id = (int)$value;
		return $this;
	}
	
	/// number
	public function getNumber()
	{
		return $this->sh_number;
	}
	
	public function setNumber($value = null)
	{
		$this->sh_number = $value;
		return $this;
	}
	
	/// name
	public function getName()
	{
		return $this->number;
	}
	
	/// route
	public function getRoute()
	{
		return (int)$this->sh_route;
	}
	
	public function setRoute($value = null)
	{
		$this->sh_route = is_null($value) ? null : (int)$value;
		return $this;
	}
	
	public function getRouteS()
	{
		return $this->route == null ? "" :
			$this->shRoute->name;
	}
	
	/// comment
	public function getComment()
	{
		return $this->sh_comment;
	}
	
	public function setComment($value = null)
	{
		$this->sh_comment = $value;
		return $this;
	}
	
	/// dateOpen
	public function getDateOpen()
	{
		return null;
	}
	
	public function getDateOpenS()
	{
		return $this->dateOpen == null ? '' : date("d.m.Y", strtotime($this->dateOpen));
	}
	
	/// dateClose
	public function getDateClose()
	{
		return ShipmentStatusHistory::findStatusDate($this->id, ShipmentStatus::SS_CLOSED);
	}	
	
	/// dateCloseS
	public function getDateCloseS()
	{
		return ShipmentStatusHistory::findStatusDate($this->id, ShipmentStatus::SS_CLOSED, true);
	}	
	
	public function setMethod($values = null)
	{
		$this->sh_method = ($values == null || $values ==[]) ? null : '{'.implode(',', $values).'}';
		return $this;
	}
	
	public function setMethodS($values = '')
	{
		$this->sh_method = '{'.$values.'}';
		//VarDumper::dump($this->sh_method);
		return $this;
	}
	
	public function getMethod()
	{
		$r =  [];
		foreach (explode(',', preg_replace('#\{?(\w)\}?#s','$1',$this->sh_method)) as $item)
			if ($item !=null)
				$r[] = (int)$item;

		return $r;
	}
	
	/// methods - return array of strings
	public function getMethodS()
	{
		$r = null;
		foreach ($this->method as $item)
			$r[]= Shippingmethods::getNameById($item);
		return $r == null ? '' : implode (', ', $r);
	}
	
	/// status
	public function getStatus()
	{
		return $this->sh_status;
	}
	
	public function setStatus($value = null)
	{	
		// если статус поменялся - то вытавляем флаг.(реализовываем HISTORY)
		$this->_statusChanged = ($value != null)&&($value != $this->status || $this->status == null) ? true : false;

		$this->sh_status=$value;
		return $this;
	}
	
	/// statusS
	public function getStatusS()
	{
		return $this->status != null ? $this->shStatus->name : '';
	}

	public function isCreated()
	{
		return $this->status == ShipmentStatus::SS_CREATED;
	}
	
	public function isOpened()
	{
		return $this->status == ShipmentStatus::SS_OPENED;
	}
	
	public function isClosed()
	{
		return $this->status == ShipmentStatus::SS_CLOSED;
	}
	
	public function isSent()
	{
		return $this->status == ShipmentStatus::SS_SENT;
	}
	
	public function isInvoiced()
	{
		return $this->status == ShipmentStatus::SS_INVOICED;
	}

	public function isClear()
	{
		return ($this->route == null)&&($this->method == []);
	}
	
	public function setCreated()
	{
		$this->status = ShipmentStatus::SS_CREATED;
		return $this;
	}
	
	public function setOpened()
	{
		$this->status = ShipmentStatus::SS_OPENED;
		return $this;
	}
	
	public function setClosed()
	{
		$this->status = ShipmentStatus::SS_CLOSED;
		return $this;
	}
	
	public function setSent()
	{
		$this->status = ShipmentStatus::SS_SENT;
		return $this;
	}
	
	public function setInvoiced()
	{
		$this->status = ShipmentStatus::SS_INVOICED;
		return $this;
	}
	
	protected function afterSave()
    {
        parent::afterSave();

		if (!$this->_statusChanged) return;

		ShipmentStatusHistory::writeItem(
			$this->id,
			$this->status,
			$this->_current_user_id);
    }
	
	public function clearProperties()
	{
		$this->route = null;
		$this->method = null;
		return $this;
	}
	
	public function setProperties(ShipmentProperties $value = null)
	{
		$this->route = $value->operator;
		$this->method = $value->method;
		return $this;
	}
	
	public function getProperties()
	{
		$prop = new ShipmentProperties;
		$prop->operator = $this->route;
		$prop->method = $this->method;
		return $prop;
	}
	
	public function ___________real_______(){}
	
	// сountItemsInShipment
	public function getCountItemsInShipment() 
	{
		return ShipmentItems::countInShipment($this->id);
	}
	
	// weightItemsInShipment
	public function getWeightItemsInShipment() 
	{
		return ShipmentItems::weightInShipment($this->id);
	}
	
	public function getNextShipmentNumber($operator = null)
	{
		$next = (int)self::model()->dbConnection->createCommand()
			->select("nextval('shipment_number')")
			->queryScalar();
			
		return self::SHIPMENT_NAME_PREFIX
				.$next
				//.'_'.$operator
				.self::SHIPMENT_NAME_POSTFIX;
	}
	
	public function setNextNumber($operator = null)
	{
		$this->number = $this->getNextShipmentNumber($operator);
		return $this;
	}

	public function startShipment()
	{
		$this->setCreated();
		$this->setOpened();
		return $this;
	}
	
	public function finishShipment()
	{
		$this->setClosed();
		return $this;
	}
	
	public function saveAttributes($attributes = [])
	{
		$this->attributes = $attributes;
		$this->save();
		return $this;
	}
	
	public function ___________static_______(){}
	
	public static function byPk($id)
	{
		return static::model()->findByPk($id);
	}
	
	// получить оператора Shipment'a
	public static function getShipmentOperator($shipment = null)
	{
		return $shipment == null ? null :
			self::model()->findByPk($shipment)->route;
	}
	
	// получить метод Shipment'a
	public static function getShipmentMethod($shipment = null)
	{
		return ($shipment == null) ? [] :
			self::model()->findByPk($shipment)->method;
	}
	
	// получить Shipment Properties
	public static function getShipmentProperties($shipment = null)
	{
		return ($shipment == null) ? [] :
			self::model()->findByPk($shipment)->properties;
	}
	
	// получить Shipment Clear
	public static function isClearShipment($shipment = null)
	{
		return ($shipment == null) ? false :
			self::model()->findByPk($shipment)->isClear();
	}
	
	public static function createShipment()
	{
		
		$sh = new self;
		
		$sh->save(false);
		$sh->setNextNumber()
			->setCreated()->setOpened()
//			->setRoute($operator)
			->startShipment()
			->save()
;
		return $sh;
	}
	
	public static function closeShipment($id = null)
	{
		if ($id == null) return false;
		$sh = self::model()->findByPk($id);
		//$si = new ShipmentItems::model()->findByAttributes(['si_item'=>$item]);
		$sh->finishShipment()->save();
		
		return $sh;
	}
	
	public function getXlDataByShipment()
	{
		$shipment_id = $this->ExportExcelBehavior->extraParam;
		// shipment's elements
		return ShipmentItems::model()->findAllByAttributes(['si_shipment'=>$shipment_id]);
	}

	public function getXlReportHeader()
	{
		return ['Item','Tracking','user','ref','weight(kg)','dimension','volume(m3)'];
	}
	
}
