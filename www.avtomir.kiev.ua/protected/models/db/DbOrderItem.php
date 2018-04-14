<?php

/**
 * This is the model class for table "order_item".
 *
 * The followings are the available columns in table 'order_item':
 * @property integer $oi_id
 * @property integer $oi_order
 * @property integer $oi_status
 * @property integer $oi_ship_method
 * @property integer $oi_dealer
 * @property string $oi_vendor
 * @property string $oi_number
 * @property string $oi_desc_en
 * @property string $oi_desc_ru
 * @property string $oi_depot
 * @property integer $oi_qty
 * @property string $oi_price
 * @property string $oi_weight
 * @property string $oi_volume
 * @property string $oi_comment_user
 * @property string $oi_comment_oper
 * @property string $oi_date_process
 * @property string $oi_date_dealer_ship
 * @property string $oi_date_received
 * @property string $oi_date_shipped
 * @property string $oiInvoice
 */
class DbOrderItem extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'order_item';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return [
			['oi_order, oi_status, oi_ship_method, oi_dealer, oi_qty', 'numerical', 'integerOnly'=>true],
			['oi_price, oi_weight, oi_volume', 'length', 'max'=>10],
            ['oi_order, oi_status, oi_ship_method, oi_dealer, oi_vendor, oi_number, oi_desc_en, oi_desc_ru, oi_depot, oi_qty, oi_price, oi_weight, oi_volume, oi_comment_user, oi_comment_oper, oi_date_process, oi_date_dealer_ship, oi_date_received, oi_date_shipped, oi_invoice', 'safe'],
			['oi_id, oi_order, oi_status, oi_ship_method, oi_dealer, oi_vendor, oi_number, oi_desc_en, oi_desc_ru, oi_depot, oi_qty, oi_price, oi_weight, oi_volume, oi_comment_user, oi_comment_oper, oi_date_process, oi_date_dealer_ship, oi_date_received, oi_date_shipped, oi_invoice', 'safe', 'on'=>'search'],
        ];
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return [
			'oiOrder' => [self::BELONGS_TO, 'DbOrder', 'oi_order'],
			'oiStatus' => [self::BELONGS_TO, 'DbOrderItemStatus', 'oi_status'],
			'oiShipMethod' => [self::BELONGS_TO, 'DbDeliveryType', 'oi_ship_method'],
			'oiDealer' => [self::BELONGS_TO, 'DbDealer', 'oi_dealer'],
            'oiInvoice' => [self::BELONGS_TO, 'DbInvoice', 'oi_invoice'],
		];
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'oi_id' => 'id',
			'oi_order' => 'Order',
			'oi_status' => 'Status',
			'oi_ship_method' => 'Ship Method',
			'oi_dealer' => 'Dealer',
			'oi_vendor' => 'Vendor',
			'oi_number' => 'Number',
			'oi_desc_en' => 'Desc En',
			'oi_desc_ru' => 'Desc Ru',
			'oi_depot' => 'Depot',
			'oi_qty' => 'Qty',
			'oi_price' => 'Price',
			'oi_weight' => 'Weight,kg',
			'oi_volume' => 'Volume m3, kg',
			'oi_comment_user' => 'Comment User',
			'oi_comment_oper' => 'Comment Oper',
			'oi_date_process' => 'Date Process',
			'oi_date_dealer_ship' => 'Date Dealer Ship',
			'oi_date_received' => 'Date Received',
			'oi_date_shipped' => 'Date Shipped',
            'oi_invoice' => 'Invoice ID',
		);
	}

	public function behaviors() {
		return [
			'ExportExcelBehavior' => [
				'class' => 'application.components.behavior.CExportExcelBehavior',
			],
		];
	}

    protected function afterSave()
    {
        parent::afterSave();
        new CalculateNewOrderStatus($this->oi_order);
        return true;
    }


	// это чтобы вне зависимости от номера заказа накладывался фильтр пользователя.
	
	// $orderItems->byId($order_id)->search()
	// 
	// $orderItems->search(new byId($order_id))
	// $orderItems->search([new byUser($user), new byId($order_id)]),
	// 
	// $orderItems->byUser($user)->byId($order_id)->search(),
	/*
	public function byUser(IRuntimeUser $user)
	{
		$criteria=new CDbCriteria();
		$criteria->join ='JOIN orders ON (o_id=oi_order)';
		$criteria->compare('o_user', $user->id());
			
		$this->getDbCriteria()->mergeWith($criteria);
		return $this;		
	}
	
	public function byId($id)
	{
		$this->getDbCriteria()->mergeWith([
			'condition'=>'oi_order='.(int)$id,
		]);
			
		return $this;		
	}
	 * 
	 */
	
	public function search($addCriteria = null)
	{
		$criteria=(new DbOrderItemCriteria($this))->criteria();
		
		if ($addCriteria)
			if (is_array($addCriteria))
				foreach ($addCriteria as $addCriteriaItem)
					$criteria->mergeWith($addCriteriaItem);
			else
				$criteria->mergeWith($addCriteria);
		
		return new CActiveDataProvider($this, [
			'criteria'=>$criteria,
		]);
	}

    public function defaultScope()
    {
        return [
            'order'=>'oi_id',
        ];
    }
    
    public function fillWith($data)
	{
		if (!is_array($data)) {
            throw new CException("fillWith must be use with array as Configuration!");
        }
		$allowedFields = ['oi_order', 'oi_status', 'oi_ship_method', 'oi_dealer', 'oi_vendor', 'oi_number', 'oi_desc_en', 'oi_desc_ru',
			'oi_depot', 'oi_qty', 'oi_price', 'oi_weight', 'oi_volume', 'oi_comment_user', 'oi_comment_oper', 
			'oi_date_process', 'oi_date_dealer_ship', 'oi_date_received', 'oi_date_shipped', 'oi_invoice', ];
		foreach ($data as $key=>$value) {
            if (in_array($key, $allowedFields)) {
                $this->{$key} = $value;
            }
        }
		return $this;
	}

    public function getInvoiceS()
    {
        return $this->oiInvoice ? $this->oiInvoice->getNumber() : "";
    }

	
	public function getDealerNameS()
	{
		return $this->oiDealer->dl_showas;
	}
	
	public function getOrderS()
	{
		return $this->oiOrder->o_number;
	}
	
	public function getStatusS()
	{
		return $this->oiStatus->ois_name;
	}
	
	public function getMethodS()
	{
		return $this->oiShipMethod->dt_name;
	}
	
	public function getDateProcessS()
	{
		return (new DateFormatted($this->oi_date_process))->date();
	}
	
	public function getDateDealerS()
	{
		return (new DateFormatted($this->oi_date_dealer_ship))->date();
	}
	
	public function getDateReceivedS()
	{
		return (new DateFormatted($this->oi_date_received))->date();
	}
	
	public function getDateShippedS()
	{
		return (new DateFormatted($this->oi_date_shipped))->date();
	}
	
	public function getTotalMoneyByLine()
	{
		return (new NumberFormatted($this->oi_qty * $this->oi_price))->value();
	}
	
	public function getCheckPriceUrl()
	{
		return "?PriceForm%5Bnumber%5D=".$this->oi_number;
	}
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	// это функция для вытаскивания набора конкретных данных
	public function getXlData()
	{
		return DbOrderItem::model()->findAll(
				(new DbOrderItemCriteria())->byId($this->ExportExcelBehavior->extraParam)
			);
	}

	// это генерация заголовка
	public function getXlReportHeader()
	{
		return ['Delivery','Dealer','Vendor','Number','Desc En','Desc Ru','qty','price','total'];
	}
	
	// это элементы строки
	public function getXlReportItem()
	{
		return [
			'method'=>$this->getMethodS(),
			'dealer'=>$this->getDealerNameS(),
			'vendor'=>$this->oi_vendor,
			'number'=>$this->oi_number,
			'desc_en'=>$this->oi_desc_en,
			'desc_ru'=>$this->oi_desc_ru,
			'qty'=>$this->oi_qty,
			'price'=>$this->oi_price,
			'total'=>$this->getTotalMoneyByLine(),
		];
	}

    // =================================================================================================================
    public function getDatasetByCriteria($criteria) {
	    $crit = new CDbCriteria();
	    if (is_array($criteria)) {
	        foreach ($criteria as $criteria1) {
                $crit->mergeWith($criteria1);
            }
        }
        else{
	        $crit->mergeWith($criteria);
        }
	    return (new DbOrderItem())
            ->with('oiOrder')
            ->with('oiOrder.oCagent')
            ->with('oiShipMethod')
            ->with('oiDealer')
            ->findAll($crit);
    }
    // =================================================================================================================
	// это функция для вытаскивания набора конкретных данных
    public function getXlDataItems()
    {
        return $this->getDatasetByCriteria((new DbOrderItemCriteria())->byType($this->ExportExcelBehavior->extraParam));
    }

    // это генерация заголовка
    public function getXlReportHeaderItems()
    {
        return [
            'Order Number',
            'Cagent',
            'ShipMethod',
            'Dealer',
            'Vendor',
            'Part Number',
            'Qty',
            'Price 1 pcs',
            'Description EN',
            'Description RU',
        ];
    }

    // это элементы строки
    public function getXlReportItemItems()
    {
        return [
            'o_number'=>$this->oiOrder->o_number,
            'ca_name'=>$this->oiOrder->oCagent->ca_name,
            //'dt_name'=>$this->oiShipMethod->dt_name,
            'method'=>$this->getMethodS(),
            //'dl_name'=>$this->oiDealer->dl_name,
            'dealer'=>$this->getDealerNameS(),
            'oi_vendor'=>$this->oi_vendor,
            'oi_number'=>"'".$this->oi_number,
            'oi_qty'=>$this->oi_qty,
            'oi_price'=>$this->oi_price,
            'desc_en'=>$this->oi_desc_en,
            'desc_ru'=>$this->oi_desc_ru,
            //'total'=>$this->getTotalMoneyByLine(),
        ];
    }
    // =================================================================================================================

	/*
	 * этот метод ВЫРЕЗАЕТ указанное количество позиций из строки
	 * и делает новую такую-же строку с другим количеством
	 * сумма количества позиций в имененной и новой строке
	 * равно изначальному количесву,
	 *
	 * пример:
	 * original.count = 12;
	 * original.split(3);
	 * =>
	 * original.count = 3;
	 * new.count = 9;
	 */
    public function split($count) {
        // $count - то - сколько надо выделить
	    if ($count < $this->oi_qty) {
            $oi = new self();
            $oi->attributes = $this->attributes;
            // new version
            $oi->oi_qty = $this->oi_qty - $count;
            $this->oi_qty = $count;
            // old version
            //$oi->oi_qty = $count;
            //$this->oi_qty -= $count;
            $oi->save();
            $this->save();
        }
    }
}
