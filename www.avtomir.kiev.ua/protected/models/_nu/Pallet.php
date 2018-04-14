<?php

/**
 * This is the model class for table "pallet".
 *
 * The followings are the available columns in table 'pallet':
 * @property integer $pl_id
 * @property string $pl_number
 * @property string $pl_weight
 * @property integer $pl_flag
 * @property string $pl_description
 * @property string $pl_comment
 * @property integer $pl_method
 * @property integer $pl_destination
 * @property integer $pl_route
 * @property integer $pl_status
 * @property integer $pl_status_user
 *
 * The followings are the available model relations:
 * @property Operators $plRoute
 * @property Cities $plDestination
 * @property Shippingmethods $plMethod
 * @property PalletItems[] $palletItems
 */
class Pallet extends LActiveRecord
{
	private $_statusChanged;
	private $_current_user_id;
	public $linesPerGrid;
	
	public static $list_key_field='pl_id';
	public static $list_name_field='pl_number';
	public static $list_sort_field='pl_id';
	
	// bit number NEW FLAG ADD #1 / 4
	const PF_HOLD = FlagBehavior::PF_1;
	
	const PALLET_NAME_PREFIX = 'AMT';
	const PALLET_NAME_POSTFIX = '';

	public function tableName()
	{
		return 'pallet';
	}

	public function rules()
	{
		return [
			['id, number, weight, description, comment, '.
			 'method, route, destination, '.
			 'flag, status, status_user, status_date, '.
			 'dimx, dimy, dimz',
				'safe'],
				
			['pl_weight','default','setOnEmpty'=>true,'value'=>0],
			
			['pl_dimx, pl_dimy, pl_dimz, pl_weight, pl_description, pl_comment',
				'safe', 'on'=>'closePallet'],
				
		//	['pl_number, pl_weight', 'required'],
		//	['pl_weight', 'length', 'max'=>10],
		//	array('pl_destination, pl_route, pl_flag, pl_method', 'numerical', 'integerOnly'=>true),
			['pl_id, pl_number, pl_method, pl_route, pl_destination, pl_flag, pl_status, '.
			 'pl_dimx, pl_dimy, pl_dimz, pl_weight, pl_description, pl_comment',
				'safe'],

		// NEW FLAG ADD #2 / 4
			['hold, flag2, flag3',
				'safe'],
				
			['pl_id, pl_number, pl_method, pl_route, pl_destination, pl_flag, pl_status'.
			 'pl_dimx, pl_dimy, pl_dimz, pl_weight, pl_description, pl_comment',
				'safe', 'on'=>'search'],
		];
	}

	public function init()
	{
		parent::init();
		$this->_statusChanged = false;
		$this->_current_user_id = Yii::app()->user->id;
		$this->linesPerGrid = 20;
	}
	
	public function behaviors() {
		return [
			'ExportExcelBehavior' => [
				'class' => 'application.components.behavior.CExportExcelBehavior',
			],
			'FlagBehavior' => [
				'class' => 'application.components.behavior.PalletBehavior',
			],
		];
	}
	
	public function relations()
	{
		return [
			'plRoute' => [self::BELONGS_TO, 'Operators', 'pl_route'],
		//	'plDestination' => [self::BELONGS_TO, 'Destinations', 'pl_destination'], // bug # if relation to view - need to use findByAttributes instead findByPk
			'plMethod' => [self::BELONGS_TO, 'Shippingmethods', 'pl_method'],
			
			'plStatus' => [self::BELONGS_TO, 'PalletStatus', 'pl_status'],
			'palletItems' => [self::HAS_MANY, 'PalletItems', 'pi_pallet'],
		];
	}

	public function attributeLabels()
	{
		return [
			'pl_id' => 'id',
			'pl_number' => 'Pallet Number',
			'pl_weight' => 'Empty pallet weight (kg)',
			'pl_status' => 'Pallet Status',
			'pl_status_user' => 'Pallet Status User',
			
			// эти поля возможно перейдут в SHIPMENT
			'pl_destination' => 'Pallet Destination',
			'pl_route' => 'Pallet Route',
			'pl_method' => 'Pallet Method',

			'pl_flag' => 'Pallet Flag',
			'pl_description' => 'Pallet Description',
			'pl_comment' => 'Pallet Comment',
			
			'pl_dimx' => 'Dim X',
			'pl_dimy' => 'Dim Y',
			'pl_dimz' => 'Dim Z',
			
			'weightTotal'=>'Total Pallet weight (kg, calculated)',
			'сountItemsOnPallet'=>'Count Items on Pallet (calculated)'

		];
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('pl_id',$this->pl_id);
		$criteria->compare('pl_number',$this->pl_number,true);
		$criteria->compare('pl_weight',$this->pl_weight);
		$criteria->compare('pl_description',$this->pl_description,true);
		$criteria->compare('pl_comment',$this->pl_comment,true);

		$criteria->compare('pl_destination',$this->pl_destination);
		$criteria->compare('pl_route',$this->pl_route);
		$criteria->compare('pl_method',$this->pl_method);

		$criteria->compare('pl_status',$this->pl_status);
		$criteria->compare('pl_status_user',$this->pl_status_user);

		if ($this->hold != null)
			$criteria->addCondition("((pl_flag>>".self::PF_HOLD.")&1)=".$this->hold);
		
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>($this->linesPerGrid==999 ? 
							false : 
							['pageSize'=>$this->linesPerGrid]), // hack for no pagination
		));
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function defaultScope() {
		return [
			'order'=>'pl_id DESC',
		];
	}
	
    public function scopes()
    {
		$opened=PalletStatus::PS_OPENED;
		$closed=PalletStatus::PS_CLOSED;
		$sent=PalletStatus::PS_SENT;
		
		return [
            'availableToScan'=>[
				'condition'=>"pl_status!=$sent",
				],
            'opened'=>[
				'condition'=>"pl_status=$opened",
				],
            'closed'=>[
				'condition'=>"pl_status=$closed",
				],
            'sent'=>[
				'condition'=>"pl_status=$sent",
				],
        ];
    }
	
	// scope byOperator
	public function byOperator($operator = null, $force = false)
	{
		if ($operator === null)
			if (!$force)
				$this->getDbCriteria()->mergeWith([
					'condition'=>'1=2',
				]);
			else return $this;
		else if ($operator > 0) 
			$this->getDbCriteria()->mergeWith([
				'condition'=>'pl_route='.(int)$operator,
			]);
		
		return $this;		
	}
	
	// scope byShipment
	public function byShipment($shipment = null, $force = false)
	{
		$shipment = (int)$shipment;
		
		if ($shipment == null)
			if (!$force)
				$this->getDbCriteria()->mergeWith([
					'condition'=>'1=2',
				]);
			else return $this;
		else if ($shipment > 0) {
			$criteria=new CDbCriteria;
			$criteria->join ='JOIN shipment_items ON (si_item=pl_id)';
			$criteria->compare('si_shipment', $shipment);
			
			$this->getDbCriteria()->mergeWith($criteria);
		}
		return $this;		
	}
	
	// scope byMethods
	public function byMethods($methods = [])  // параметр - массив из желаемых типов отгрузки
	{
		if ($methods == null) $methods = [];
		if ($methods != []) {
			$array = implode(',', $methods);
			$this->getDbCriteria()->mergeWith([
				'condition'=>"pl_method in ($array)",
			]);
		}
		
		return $this;		
	}
	
	public function ________set_get____________(){}
	
	/// id
	public function getId()
	{
		return $this->pl_id;
	}
	
	public function setId($value = null)
	{
		$this->pl_id = $value;
		return $this;
	}
	
	/// number
	public function getNumber()
	{
		return $this->pl_number == null ? '' : $this->pl_number;
	}
	
	public function setNumber($value = null)
	{	
		$this->pl_number=$value;
		return $this;
	}
	
	/// weight
	public function getWeight()
	{
		return ($this->pl_weight == null || $this->pl_weight == "") ? 0 : $this->pl_weight;
	}
	
	public function setWeight($value = null)
	{	
		$this->pl_weight=$value;
		return $this;
	}
	
	/// weightEmpty
	public function getWeightEmpty()
	{
		return $this->weight;
	}
	
	/// weightTotal
	public function getWeightTotal() 
	{
		return $this->weightEmpty + $this->weightItemsOnPallet;
	}
	
	/// weightTotalS
	public function getWeightTotalS() 
	{
		return $this->weightTotal." kg";
	}
	
	/// description
	public function getDescription()
	{
		return $this->pl_description;
	}
	
	public function setDescription($value = null)
	{	
		$this->pl_description=$value;
		return $this;
	}
	
	/// comment
	public function getComment()
	{
		return $this->pl_comment;
	}
	
	public function setComment($value = null)
	{	
		$this->pl_comment=$value;
		return $this;
	}
	
	/// destination
	public function getDestination()
	{
		return $this->pl_destination != null ? (int)$this->pl_destination : 0;
	}
	
	public function setDestination($value = null)
	{	
		$this->pl_destination=$value;
		return $this;
	}
	
	/// method
	public function getMethod()
	{
		return $this->pl_method != null ? (int)$this->pl_method : 0;
	}
	
	public function setMethod($value = null)
	{	
		$this->pl_method=$value;
		return $this;
	}
	
	/// route
	public function getRoute()
	{
		return $this->pl_route !=null ? (int)$this->pl_route : 0;
	}
	
	public function setRoute($value = null)
	{	
		$this->pl_route=$value;
		return $this;
	}
	
	/// plDestination
	public function getPlDestination() 
	{
		return ($this->destination == null) ? null :
			Destinations::model()->findByPk($this->destination);
	}
	
	/// destinationS
	public function getDestinationS() 
	{
		return $this->plDestination == null ? "n/a" : $this->plDestination->name;
	}
	
	/// routeS
	public function getRouteS() 
	{
		return $this->plRoute == null ? "n/a" : $this->plRoute->name;
	}
	
	/// methodS
	public function getMethodS() 
	{
		return $this->plMethod == null ? "n/a" : $this->plMethod->name;
	}
	
	/// status
	public function getStatus()
	{
		return $this->pl_status;
	}
	
	public function setStatus($value = null)
	{	
		// если статус поменялся - то вытавляем флаг.(реализовываем HISTORY)
		$this->_statusChanged = ($value != null)&&($value != $this->status || $this->status == null) ? true : false;

		$this->pl_status=$value;
		return $this;
	}
	
	public function getStatusS()
	{
		return $this->plStatus->name;
	}
	
	public function isCreated()
	{
		return $this->status == PalletStatus::PS_CREATED;
	}
	
	public function isOpened()
	{
		return $this->status == PalletStatus::PS_OPENED;
	}
	
	public function isClosed()
	{
		return $this->status == PalletStatus::PS_CLOSED;
	}
	
	public function isSent()
	{
		return $this->status == PalletStatus::PS_SENT;
	}
	
	// able to insert boxes to pallet
	public function isActive()
	{
		return $this->isOpened();
	}
	
	public function setCreated()
	{
		$this->status=PalletStatus::PS_CREATED;
		return $this;
	}
	
	public function setOpened()
	{
		$this->status=PalletStatus::PS_OPENED;
		return $this;
	}
	
	public function setClosed()
	{
		$this->status=PalletStatus::PS_CLOSED;
		return $this;
	}
	
	public function setSent()
	{
		$this->status=PalletStatus::PS_SENT;
		return $this;
	}
	
	public function getFlag()
	{
		return $this->pl_flag != null ? $this->pl_flag : 0;
	}
	
	public function setFlag($value = null)
	{	
		$this->pl_flag=(int)$value;
		return $this;
	}
	
	protected function beforeSave()
    {
		// заполняем дату и юзера
        if (parent::beforeSave()) {
			if ($this->status == null) $this->setCreated();
			
			$this->pl_status_date = new CDbExpression('NOW()');
			$this->pl_status_user = $this->_current_user_id;
			
			if ($this->method == null) $this->method = null;
			if ($this->route == null) 	$this->route = null;
			if ($this->destination == null) $this->destination = null;
			
			if ($this->pl_flag == null) $this->pl_flag=0;
			if ($this->weight == null) $this->weight=0;
			
			return true;
		}
		return false;
    }

	protected function afterSave()
    {
        parent::afterSave();

		if (!$this->_statusChanged) return;
		
		if ($this->isSent())
			// всем элементам палеты сказать setSent()
			foreach (PalletItems::model()->findAllByAttributes(['pi_pallet'=>$this->id]) 
				as $item)
					Trackings::model()->findByPk($item->pi_item)->setSent()->save();
		
		if ($this->isClosed())
			// всем элементам палеты сказать setScanOut()
			foreach (PalletItems::model()->findAllByAttributes(['pi_pallet'=>$this->id]) 
				as $item)
					Trackings::model()->findByPk($item->pi_item)->setScanOut()->save();
					
		PalletStatusHistory::writeItem(
			$this->id,
			$this->status,
			$this->pl_status_user);
    }
	
	public function getNextPalletNumber()
	{
		$next = (int)self::model()->dbConnection->createCommand()
			->select("nextval('pallet_number')")
			->queryScalar();
			
		return self::PALLET_NAME_PREFIX.$next.self::PALLET_NAME_POSTFIX;
	}
	
	public function setNextNumber()
	{
		$this->number = $this->getNextPalletNumber();
		return $this;
	}
	
	/// dateClose
	public function getDateClose()
	{
		return PalletStatusHistory::findStatusDate($this->id, PalletStatus::PS_CLOSED);
	}	
	
	/// dateCloseS
	public function getDateCloseS()
	{
		return PalletStatusHistory::findStatusDate($this->id, PalletStatus::PS_CLOSED, true);
	}	
	
	/// dimX
	public function getDimX()
	{
		return $this->pl_dimx != null ? $this->pl_dimx : 0;
	}
	
	public function setDimX($value = null)
	{	
		$this->pl_dimx=$value;
		return $this;
	}
	
	/// dimY
	public function getDimY()
	{
		return $this->pl_dimy != null ? $this->pl_dimy : 0;
	}
	
	public function setDimY($value = null)
	{	
		$this->pl_dimy=$value;
		return $this;
	}
	
	/// dimZ
	public function getDimZ()
	{
		return $this->pl_dimz != null ? $this->pl_dimz : 0;
	}
	
	public function setDimZ($value = null)
	{	
		$this->pl_dimz=$value;
		return $this;
	}
	
	/// dimS
	public function getDimS()
	{
		$SEPARATOR = 'x';
		$PREFIX = '';
		$SUFFIX = ' in';

		$data[]=$this->dimX;
		$data[]=$this->dimY;
		$data[]=$this->dimZ;
		
		return 
			$PREFIX.
			implode($SEPARATOR, $data)
			.$SUFFIX;
	}

	/// printCommand
	public function getPrintCommand()
	{
		$PREFIX='';
		$SEPARATOR=';';
		$SUFFIX='#';
		
		$data[] = '12'; 					// template Number 11,12,13,etc
		
		$data[] = $this->number; 			// field 1 - AMTxxx
		$data[] = $this->destinationS;		// field 2 - DESTINATION
		$data[] = $this->methodS;			// field 3 - SHIPPING METHOD (AVIA / SEA)
		$data[] = $this->routeS;			// field 4 - SHIPPING ROUTE (Dnipro, etc)
		$data[] = $this->weightTotalS;		// field 5 - WEIGHT TOTAL
		$data[] = $this->dimS;				// field 6 - DIMENSIONS
		$data[] = $this->countItemsOnPallet;// field 7 - сountItemsOnPallet
		$data[] = $this->comment;			// field 8 - comment

		$output[] = $PREFIX;
		$output[] = implode($SEPARATOR, $data);
		$output[] = $SUFFIX;
		
		return implode ("", $output);
	}
	
	// сountItemsOnPallet
	public function getCountItemsOnPallet() 
	{
		return PalletItems::countInPallet($this->id);
	}
	
	// weightItemsOnPallet
	public function getWeightItemsOnPallet()
	{
		return PalletItems::weightInPallet($this->id);
	}
	
	// volumeItemsOnPallet
	public function getVolumeItemsOnPallet()
	{
		return PalletItems::volumeInPallet($this->id);
	}

	// палетта пустая
	public function isEmpty() 
	{
		return $this->countItemsOnPallet == 0;
	}
	
	public function setProperties(DestinationProperties $value = null)
	{
		/*
		$this->route = $value->operator;
		$this->method = $value->method;
		*/
	}
	
	public function getProperties()
	{
		return
			new DestinationProperties($this->destination, $this->route, $this->method);
	}
	
	public function __________static___________(){}
	
	public static function createPallet($model=__CLASS__)
	{
		$pallet = new $model;
		$pallet->save(false);
		$pallet->setNextNumber()->setCreated()->setOpened()->save();
		
		return $pallet;
	}
	
	public static function openPallet($id = null)
	{
		if ($id == null) return false;
		return self::model()->findByPk($id)->setOpened()->save();
	}
	
	public static function closePallet($id = null)
	{
		if ($id == null) return false;
		
		return self::model()->findByPk($id)->setClosed()->save();
	}
	
	/*
	public static function unAssignPallet($pallet = null)
	{
		// если палет не указан то RETURN
		if ($pallet == null) return false;
		
		// берем паллет
		$p = self::model()->findByPk($pallet);
		
		// чистим поля
		$p->destination=null;
		$p->method=null;
		$p->route=null;
		
		// сохраняем палетту
		return $p->save();
	}
	*/
	
	public function unAssignPallet()
	{
		$this->destination=null;
		$this->method=null;
		$this->route=null;
		return $this;
	}
	
	public static function assignPallet($pallet = null)
	{
		// если палет не указан то RETURN
		if ($pallet == null) return false;
		
		// ищем коробки на паллете - если пусто RETURN
		if (PalletItems::isEmptyPallet($pallet)) return false;
		
		// берем 1 коробку
		$item = PalletItems::model()->findByAttributes(["pi_pallet" => $pallet]);
		
		// берем паллет
		$p = self::model()->findByPk($pallet);

		// переносим атрибуты
		$p->destination=$item->piItem->tr_destination;
		$p->method=$item->piItem->tr_method;
		$p->route=$item->piItem->tr_route;
		
		// сохраняем палетту
		return $p->save();
	}
		
	public function getFwdAttributes()
	{
		return [
			'destination'=>$this->destination,
			'route'=>$this->route,
			'method'=>$this->method,
			];
	}
	
	public static function getFwdAttributesById($pallet_id = null)
	{
		if ($pallet_id === null) return [];
		
		$ar = self::model()->findByPk($pallet_id);
		
		return !$ar ? [] :
			$ar->getFwdAttributes();
	}
	
	// получить Pallet Properties
	public static function getPalletProperties($pallet = null)
	{
		return ($pallet == null) ? [] :
			self::model()->findByPk($pallet)->properties;
	}
	
	/*
	public static function checkPalletAttributes($pallet = null, $attributes = [])
	{
		$values =[
			'destination'=>null,
			'route'=>null,
			'method'=>null,
		];
		
		// если палет не указан то RETURN
		if ($pallet == null) return false;
		// если нет аттрибутов то RETURN
		if ($attributes == []) return false;

		// заполнили массив
		foreach ($attributes as $key=>$value)
			$values[$key]=$value;
		
		// берем паллет
		$p = self::model()->findByPk($pallet);

		$ok = true;
		// сверяем атрибуты
		$ok = $ok && ($p->destination==$values['destination']);
		$ok = $ok && ($p->method==$values['method']);
		$ok = $ok && ($p->route==$values['route']);
		
		return $ok;
	} */

	public function UpdateAttributes($attributes)
	{
		$this->scenario = 'closePallet';
		$this->attributes = $attributes;
		return $this;
	}

	public function getXlExtraHeader()
	{
		$pallet_id = $this->ExportExcelBehavior->extraParam;
		$pallet = Pallet::model()->findByPk($pallet_id);
		
		return [
			[
				'Pallet number:',
				'','',
				$pallet->number, // func
			],
			[
				'Number of boxes on the pallet:',
				'','',
				$pallet->countItemsOnPallet, // func
			],
			[
				'Empty pallet weight (kg):',
				'','',
				number_format($pallet->weightEmpty, 2), // func
			],
			[
				'Weight of boxes on the pallet (kg):',
				'','',
				number_format($pallet->weightItemsOnPallet, 2), // func
			],
			[
				'Volume of boxes on the pallet (m3):',
				'','',
				number_format($pallet->volumeItemsOnPallet, 2), // func
			],
			[
				'Total pallet weight (kg):',
				'','',
				number_format($pallet->weightTotal, 2),
			],
		];
	}
	
	public function getXlReportHeader()
	{
		return ['Item','Tracking','user','ref','weight(kg)','dimension','volume(m3)'];
	}
	
	public function getXlData()
	{
		$pallet_id = $this->ExportExcelBehavior->extraParam;
		return PalletItems::model()->findAllByAttributes(['pi_pallet'=>$pallet_id]);;
	}

}
