<?php

/**
 * This is the model class for table "trackings".
 *
 * The followings are the available columns in table 'trackings':
 * @property integer $tr_id
 * @property string $tr_tracking
 * @property integer $tr_carrier
 * @property integer $tr_status
 * @property string $tr_content
 * @property string $tr_total
 * @property integer $tr_owner
 * @property integer $tr_tag
 * @property string $tr_weight
 * @property integer $tr_dimx
 * @property integer $tr_dimy
 * @property integer $tr_dimz
 * @property string $tr_comment_owner
 * @property string $tr_comment_operator
 * @property string $tr_date
 * @property string $tr_date_statusp
 * @property integer $tr_statusp 
 * @property string $tr_number
 * @property string $tr_user_ref
 * @property integer $tr_method
 * @property integer $tr_destination
 * @property integer $tr_route
 * @property integer $tr_ready
 * @property integer $tr_status_user
 
 * The followings are the available model relations:
 * @property TrackingStatus $trStatus
 * @property TrackingCarriers $trCarrier
 * @property Tags $trTag
 * @property Users $trOwner
 * @property Shippingmethods $trMethod
 * @property Operators $trRoute
 * @property Users $trStatusUser
 * @property PalletItems[] $palletItems
 */
 
class Trackings extends CActiveRecord
{
	// bit number NEW FLAG ADD #1 / 4
	const PF_HOLD = FlagBehavior::PF_1;
	
	const PF_2 = 1; // 2
	const PF_3 = 2; // 4
	const PF_4 = 3; // 8
	const PF_5 = 4; // 16
	
	const T_NORMAL = 0;
	const T_ARCHIVE = 1;
	
	public $pallet;
	
	public $statusChanged;
	public $current_user_id;
	public $linesPerGrid;
	
	private function ________standard_Yii_________() {}
	
	public function tableName()
	{
		return 'trackings';
	}

	public function rules()
	{
		return [
			['pallet','safe', 'on'=>'search'],
		
			['tr_weight',
				'numerical'],
				
			['trackingNumber, weight, '.
			'tr_tracking, tr_carrier, tr_status, tr_content, tr_total, tr_owner, tr_tag, tr_weight, tr_dimx, tr_dimy, tr_dimz, tr_comment_owner, tr_comment_operator, tr_date, tr_date_statusp, tr_statusp, '.
				'tr_number, tr_user_ref, tr_method, tr_destination, tr_route, tr_ready, tr_status_user, tr_flag, tr_archive',
					'safe', 'on'=>'updateAdmin'],
					
			['trackingNumber, weight, '.
			'tr_tracking, tr_carrier, tr_status, tr_content, tr_total, tr_owner, tr_tag, tr_weight, tr_dimx, tr_dimy, tr_dimz, tr_comment_owner, tr_comment_operator, tr_date, tr_date_statusp, tr_statusp, '.
				'tr_number, tr_user_ref, tr_method, tr_destination, tr_route, tr_ready, tr_status_user, tr_flag, tr_archive',
					'safe', 'on'=>'scanIn'],

			['tr_id, tr_tracking, tr_carrier, tr_status, tr_content, tr_total, tr_owner, tr_tag, tr_weight, tr_dimx, tr_dimy, tr_dimz, tr_comment_owner, tr_comment_operator, tr_date, tr_date_statusp, tr_statusp, '.
				'tr_number, tr_user_ref, tr_method, tr_destination, tr_route, tr_ready, tr_status_user, tr_flag, tr_archive',
					'safe', 'on'=>'userAdd'],
				
			['tr_id, tr_tracking, tr_carrier, tr_status, tr_content, tr_total, tr_owner, tr_tag, tr_weight, tr_dimx, tr_dimy, tr_dimz, tr_comment_owner, tr_comment_operator, tr_date, tr_date_statusp, tr_statusp, '.
				'tr_number, tr_user_ref, tr_method, tr_destination, tr_route, tr_ready, tr_status_user, tr_flag, tr_archive',
					'safe', 'on'=>'search'],
					
			//['tr_id, tr_tracking, tr_carrier, tr_status, tr_content, tr_total, tr_owner, tr_tag, tr_weight, tr_dimx, tr_dimy, tr_dimz, tr_comment_owner, tr_comment_operator, tr_status_date, tr_date_statusp, tr_statusp, tr_number, tr_user_ref, tr_method, tr_destination, tr_route, tr_ready, tr_status_user',
			//	'safe'],
				
			//['tr_destination',	'required','on'=>'insert, update'],
			//['tr_id, tr_tracking, tr_carrier, tr_method, tr_status, tr_content, tr_total, tr_user_ref, tr_owner, tr_tag, tr_weight, tr_dimx, tr_dimy, tr_dimz, tr_comment_owner, tr_comment_operator, tr_date, tr_date_statusp','safe', 'on'=>'scan1'],
			//['tr_tracking, tr_tag',	'required'],
			//['tr_route', 'required'], // оператор должен быть !
			//['tr_content, tr_total', 'required'],
			//['tr_carrier, tr_status, tr_statusp, tr_owner, tr_dimx, tr_dimy, tr_dimz',	'numerical', 'integerOnly'=>true],
			//['tr_total, tr_weight', 'length', 'max'=>10],
			//['tr_tracking, tr_user_ref, tr_method, tr_destination, tr_content, tr_tag, tr_comment_owner, tr_comment_operator, tr_date, tr_date_statusp, tr_number', 'safe'],

		];
	}

	public function init()
	{
		parent::init();
		$this->statusChanged = false;
		$this->current_user_id = Yii::app()->user->id;
		$this->linesPerGrid = 20;
	}
	
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'trStatus' => array(self::BELONGS_TO, 'TrackingStatus', 'tr_status'),
			'trCarrier' => array(self::BELONGS_TO, 'TrackingCarriers', 'tr_carrier'),
			'trTag' => array(self::BELONGS_TO, 'Tag', 'tr_tag'),
			'trOwner' => array(self::BELONGS_TO, 'User', 'tr_owner'),
			'trMethod' => array(self::BELONGS_TO, 'Shippingmethods', 'tr_method'),
			'trRoute' => array(self::BELONGS_TO, 'Operators', 'tr_route'),
//			'trDestination' => array(self::BELONGS_TO, 'Destinations', 'tr_destination'),
			'trStatusUser' => array(self::BELONGS_TO, 'Users', 'tr_status_user'),
			
			'palletItems' => array(self::HAS_ONE, 'PalletItems', 'pi_item',
				//'tbl_post_category(post_id, category_id)'),			
				//'order'=>'',
				//'with'=>'pallet_items'
			),
			'trackingStatusHistories' => array(self::HAS_MANY, 'TrackingStatusHistory', 'sh_track_id'),
		);
	}

	public function behaviors() {
		return [
			'ExportExcelBehavior' => [
				'class' => 'application.components.behavior.CExportExcelBehavior',
			],
			'FlagBehavior' => [
				'class' => 'application.components.behavior.TrackingBehavior',
			],
			'ERememberFiltersBehavior' => [
				'class' => 'application.components.ERememberFiltersBehavior',
				'defaults'=>[],
				'defaultStickOnClear'=>false,
				'scenarioName'=>'search',
				'clearAttributes'=>true,
			],
		];
	}
	
	public function attributeLabels()
	{
		return array(
			'tr_id' => 'id',
			'tr_tracking' => 'Tracking',
			'tr_carrier' => 'Carrier',
			'tr_number' => 'AML Number',

			'tr_owner' => 'Owner',
			'tr_tag' => 'Tag',
			'tr_user_ref' => 'User Reference',
			'tr_content' => 'Content',
			'tr_total' => 'Total,$',
			
			'tr_weight' => 'Weight (kg)',
			'tr_dimx' => 'Dim X (inch)',
			'tr_dimy' => 'Dim Y (inch)',
			'tr_dimz' => 'Dim Z (inch)',

			'tr_status' => 'Status',
			'tr_date' => 'Date',
			'tr_status_user' => 'User',
			
			'tr_comment_owner' => 'Owner Comment',
			'tr_comment_operator' => 'Operator Comment',
			
			'tr_statusp' => 'Post Status',
			'tr_date_statusp' => 'Date Post Status',
			
			'tr_method' => 'Shipping Method',
			'tr_destination' => 'Destination',
			'tr_route' => 'Route (shipping operator)',
			
			'tr_flag' => 'Flag for bits',
			'tr_ready' => 'Box Ready to send', // 1 - ready to send, 0 - No
			'tr_archive' => 'Archive status', // 1 - Archive, 0 - No
		);
	}
	
	public function buildCriteria($period = null)
	{
		$criteria=new CDbCriteria;

		
		$criteria->compare('tr_id',$this->tr_id);
		$criteria->compare('upper(tr_tracking)',trim(mb_strtoupper($this->tr_tracking)),true);
		$criteria->compare('tr_carrier',$this->tr_carrier);
		$criteria->compare('tr_status',$this->tr_status);
		$criteria->compare('upper(tr_content)',mb_strtoupper($this->tr_content),true);
		$criteria->compare('tr_total',$this->tr_total,true); // numeric
		$criteria->compare('tr_owner',$this->tr_owner);
		$criteria->compare('tr_tag',$this->tr_tag);
		
		$criteria->compare('tr_weight',$this->tr_weight); // numberic
		$criteria->compare('tr_dimx',$this->tr_dimx);
		$criteria->compare('tr_dimy',$this->tr_dimy);
		$criteria->compare('tr_dimz',$this->tr_dimz);
		
		$criteria->compare('upper(tr_comment_owner)',mb_strtoupper($this->tr_comment_owner),true);
		$criteria->compare('upper(tr_comment_operator)',mb_strtoupper($this->tr_comment_operator),true);
		
		
		if ($period != null) { 
			if (($period->date_1 != null)  && ($period->date_2 != null)) 
				$criteria->addBetweenCondition('tr_date::date', $period->date_1, $period->date_2);
			if (($period->date_1 != null) && ($period->date_2 == null))
				$criteria->compare('tr_date::date',$period->date_1);
		} else
			$criteria->compare('tr_date::date',$this->tr_date);
		
		
		$criteria->compare('tr_date_statusp',$this->tr_date_statusp,true);
		$criteria->compare('tr_statusp',$this->tr_statusp);
		
		$criteria->compare('upper(tr_number)',mb_strtoupper($this->tr_number),true);
		$criteria->compare('upper(tr_user_ref)',mb_strtoupper($this->tr_user_ref),true);
		$criteria->compare('tr_method',$this->tr_method);
		$criteria->compare('tr_destination',$this->tr_destination);
		$criteria->compare('tr_route',$this->tr_route);
		$criteria->compare('tr_ready',$this->tr_ready);
		$criteria->compare('tr_archive',$this->tr_archive);
		
		/*
		$criteria->join=
						'left join 
						(select sh_track_id, sh_date, sh_status 
						from tracking_status_history tsh1
						where sh_date=(select max(tsh2.sh_date)
							from tracking_status_history tsh2
							where tsh1.sh_track_id = tsh2.sh_track_id
							and tsh2.sh_status=20)
						) as tsh 

						on tsh.sh_track_id=tr_id	
						';

		$criteria->select='*'
							.', case when tsh.sh_date isnull then tr_status_date else tsh.sh_date end date_'
							.', case when tsh.sh_status isnull then 20 else tsh.sh_status end status_';
							
//		$criteria->select .= ', case when tsh.sh_date isnull then tr_status_date else tsh.sh_date end date_';
//		$criteria->select .= ', case when tsh.sh_status isnull then 20 else tsh.sh_status end status_';
		
//		$criteria->addBetweenCondition('date_', '2016-05-16', '2016-05-25');
		
		//$criteria->scopes=['newfields'];
		*/
		
		//$criteria->order = 'tr_date desc';

		return $criteria;
	}
	
	public function defaultScope() {
		return [
			//'condition'=>"tr_archive=".self::T_NORMAL,
			'order'=>'tr_date desc',
		];
	}
	
    public function scopes()
    {
		return [
            'ready'=>[
				'condition'=>"tr_ready=1",
				],
            'currentuser'=>[
				'condition'=>"tr_owner = ".$this->current_user_id,
				],
            'scanned'=>[
                'condition'=>"tr_status = ".TrackingStatus::TS_SCAN,
				],
            'recently'=>[
				'condition'=>"tr_status = ".TrackingStatus::TS_SCAN,
				'limit' => 10,
				],
        ];
    }
	
	private function buildProvider($criteria, $extra = null)
	{
		$params=[
			'criteria'=>$criteria,
			'pagination'=>($this->linesPerGrid==999 ? 
							false : 
							['pageSize'=>$this->linesPerGrid]), // hack for no pagination
			];
		
		if ($extra) $params=array_merge($params, $extra);
		
		return new CActiveDataProvider($this, $params);
	}
	
	public function search($period = null)
	{
		return $this->buildProvider($this->buildCriteria($period));
	}

	public function searchAvailableToScan()
	{
		$criteria = $this->buildCriteria();
		
		// scanned
		$criteria->compare("tr_status", TrackingStatus::TS_SCAN);
		// ready
		$criteria->compare("tr_ready", 1);
		// join
		$criteria->with=['trTag'];
		// flag HOME=0
		$criteria->compare( "((tg_flag>>".Tag::TF_HOME.")&1)", 0);
		
		return $this->buildProvider($criteria);
	}
	
	public function searchStock()
	{
		$criteria = $this->buildCriteria();
		// not sent
		$criteria->addCondition("tr_status < ".TrackingStatus::TS_SENT);
		// non archive
		$criteria->addCondition("tr_archive = ".self::T_NORMAL);
		// join
		$criteria->with=['palletItems.piPallet','trTag'];
		// flag HOME=0
		$criteria->compare( "((tg_flag>>".Tag::TF_HOME.")&1)", 0);
		
		$criteria->compare( 'upper("piPallet".pl_number)', mb_strtoupper($this->pallet), true); 
		
		return $this->buildProvider($criteria,
			['sort'=>[
				'attributes'=>[
					'pallet'=>[
						'asc'=>'"palletItems".pi_pallet ASC',
						'desc'=>'"palletItems".pi_pallet DESC',
						],
//					'*',
					],
				],
			]
		);
	}
	
	public function searchReady()
	{
		$criteria = $this->buildCriteria();
		
		// ready
		$criteria->addCondition("tr_ready = 1");
		// not sent
		$criteria->addCondition("tr_status < ".TrackingStatus::TS_SENT);
		// non archive
		$criteria->addCondition("tr_archive = ".self::T_NORMAL);
		// join
		$criteria->with=['palletItems.piPallet','trTag'];
		// pallet (screen: operator/report)
		$criteria->compare( 'upper("piPallet".pl_number)', mb_strtoupper($this->pallet), true); 
//		$criteria->compare( 'upper(pl_number)', mb_strtoupper($this->pallet), true); 
		// flag HOME=0
		$criteria->compare( "((tg_flag>>".Tag::TF_HOME.")&1)", 0);
		
		return $this->buildProvider($criteria,
			['sort'=>[
				'attributes'=>[
					'pallet'=>[
						'asc'=>'"palletItems".pi_pallet ASC',
						'desc'=>'"palletItems".pi_pallet DESC',
						],
//					'*',
					],
				],
			]
		);
		
		return new CActiveDataProvider($this, [
			'criteria'=>$criteria,
			'pagination'=>['pageSize'=>$this->linesPerGrid],
		]);
	}
	
	public function searchSent($period = null)
	{
		$criteria = $this->buildCriteria();
		
		// sent
		$criteria->addCondition("tr_status = ".TrackingStatus::TS_SENT);
		// non archive
		$criteria->addCondition("tr_archive = ".self::T_NORMAL);
		// join
		$criteria->with=['palletItems.piPallet','trTag'];
		// pallet)
		$criteria->compare( 'upper("palletItems".pl_number)', mb_strtoupper($this->pallet), true);
		// flag HOME=0
		$criteria->compare( "((tg_flag>>".Tag::TF_HOME.")&1)", 0);
		
		if (($period != null) && ($period->date_1 != null) && ($period->date_2 != null)) 
			{
				$d1="'".$period->date_1."'";
				$d2="'".$period->date_2."'";
				$criteria->join=
						"join(select sh_track_id, max(sh_date) sh_date
						from tracking_status_history
						where 
						sh_status=50
						and sh_date::date between $d1 and $d2
						group by sh_track_id) j1 on (j1.sh_track_id = tr_id)";
			}

		return $this->buildProvider($criteria);
	}
	
	//----------------------------------------------------------------------------------------------------------------------
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	private function ________set_get______________() {}
	
	/// id
	public function getId()
	{
		return (int)$this->tr_id;
	}
	
	public function setId($value = null)
	{
		$this->tr_id = (int)$value;
		return $this;
	}

	/// carrier
	public function getCarrier()
	{
		return (int)$this->tr_carrier;
	}
	
	public function setCarrier($value = null)
	{
		$this->tr_carrier = (int)$value;
		return $this;
	}
	
	/// internalNumber
	public function getInternalNumber()
	{
		return $this->tr_number != null ? $this->tr_number : '';
	}
	
	public function setInternalNumber($value = null)
	{
		$this->tr_number = $value;
		return $this;
	}
	
	/// trackingNumber
	public function getTrackingNumber()
	{
		return $this->tr_tracking != null ? $this->tr_tracking : '';
	}
	
	public function setTrackingNumber($value = null)
	{
		$this->tr_tracking = TrackNumber::trackingCanonize($value);
		$this->setCarrierFromTracking();
		return $this;
	}

	public function setCarrierFromTracking()
	{                
		$info = TrackNumber::trackingAnalyze($this->trackingNumber);
		$this->carrier = ($info) ? $info['carrier_id'] : 0;
		return $this;
	}
	
	/// owner
	public function getOwner()
	{
		return $this->tr_owner != null ? (int)$this->tr_owner : 0;
	}
	
	/// ownerS
	public function getOwnerS()
	{
		return $this->owner != null ? $this->trOwner->name : '';
	}
	
	public function setOwner($value = null)
	{
		$this->tr_owner = (int)$value;
		return $this;
	}
	
	/// tag
	public function getTag()
	{
		return $this->tr_tag != null ? (int)$this->tr_tag : 0;
	}
	
	/// tagStr
	public function getTagS()
	{
		return $this->tag != null ? $this->trTag->name : '';
	}
	
	public function setTag($value = null)
	{
		$this->tr_tag = $value;
		return $this;
	}
	
	/// userRef
	public function getUserRef()
	{
		return $this->tr_user_ref != null ? $this->tr_user_ref : '';
	}
	
	public function setUserRef($value = null)
	{
		$this->tr_user_ref = $value;
		return $this;
	}
	
	/// content
	public function getContent()
	{
		return $this->tr_content != null ? $this->tr_content : '';
	}
	
	public function setContent($value = null)
	{
		$this->tr_content = $value;
		return $this;
	}
	
	/// total
	public function getTotal()
	{
		return $this->tr_total != null ? $this->tr_total : 0;
	}
	
	public function setTotal($value = null)
	{
		$this->tr_total = $value;
		return $this;
	}
	
	// weight
	public function getWeight()
	{
		return $this->tr_weight; // != null ? $this->tr_weight : 0;
	}
	
	public function getWeightS()
	{
		$SUFFIX = ' kg';
		return $this->weight.$SUFFIX;
	}
	
	public function setWeight($value = null)
	{
		if (is_string($value))
			$value = str_replace(',', '.', $value); 
		
		$this->tr_weight = (float)$value;
		return $this;
	}
	
	/// dimX
	public function getDimX()
	{
		return $this->tr_dimx != null ? $this->tr_dimx : 0;
	}
	
	public function setDimX($value = null)
	{	
		$this->tr_dimx=$value;
		return $this;
	}
	
	/// dimY
	public function getDimY()
	{
		return $this->tr_dimy != null ? $this->tr_dimy : 0;
	}
	
	public function setDimY($value = null)
	{	
		$this->tr_dimy=$value;
		return $this;
	}
	
	/// dimZ
	public function getDimZ()
	{
		return $this->tr_dimz != null ? $this->tr_dimz : 0;
	}
	
	public function setDimZ($value = null)
	{	
		$this->tr_dimz=$value;
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
	
	/// destination
	public function getDestination()
	{
		return $this->tr_destination != null ? (int)$this->tr_destination : 0;
	}
	
	public function setDestination($value = null)
	{	
		$this->tr_destination=(int)$value;
		return $this;
	}
	
	/// method
	public function getMethod()
	{
		return $this->tr_method != null ? $this->tr_method : 0;
	}
	
	public function setMethod($value = null)
	{	
		$this->tr_method=(int)$value;
		return $this;
	}
	
	/// route
	public function getRoute()
	{
		return $this->tr_route != null ? $this->tr_route : 0;
	}
	
	public function setRoute($value = null)
	{	
		$this->tr_route=(int)$value;
		return $this;
	}
	
	/// trDestination - FIX for view
	public function getTrDestination() 
	{
		return ($this->destination == null) ? null :
			Destinations::model()->findByPk($this->destination);
	}
	
	/// destinationS
	public function getDestinationStr() 
	{
		return $this->trDestination == null ? "n/a" : $this->trDestination->name;
	}
	
	/// routeS
	public function getRouteS() 
	{
		return $this->trRoute == null ? "" : $this->trRoute->name;
	}
	
	/// methodS
	public function getMethodS() 
	{
		return $this->trMethod == null ? "" : $this->trMethod->name;
	}
	
	/// operatorComment
	public function getOperatorComment()
	{
		return $this->tr_comment_operator != null ? $this->tr_comment_operator : '';
	}
	
	public function setOperatorComment($value = null)
	{
		$this->tr_comment_operator = $value;
		return $this;
	}
	
	/// ownerComment
	public function getOwnerComment()
	{
		return $this->tr_comment_owner != null ? $this->tr_comment_owner : '';
	}
	
	public function setOwnerComment($value = null)
	{
		$this->tr_comment_owner = $value;
		return $this;
	}
	
	/// postStatus
	public function getPostStatus()
	{
		return $this->tr_statusp != null ? $this->tr_statusp : 0;
	}
	
	public function setPostStatus($value)
	{
		$this->tr_statusp = (int)$value;
		return $this;
	}

	/// postDate
	public function getPostDate()
	{
		return tr_date_statusp;
	}
	
	public function setPostDate($value)
	{
		$this->tr_date_statusp = $value;
		return $this;
	}
	
	/// status
	public function getStatus()
	{
		return $this->tr_status != null ? $this->tr_status : 0;
	}
	
	public function setStatus($value = null)
	{	
		// если статус поменялся - то вытавляем флаг.(реализовываем HISTORY)
		$this->statusChanged = ($value != null)&&($value != $this->status || $this->status == null) ? true : false;
		$this->tr_status=(int)$value;
		
		if ($this->isScan() && $this->date == null) $this->date = new CDbExpression('NOW()');

		return $this;
	}
	
	/// statusUser
	public function getStatusUser()
	{
		return $this->tr_status_user != null ? $this->tr_status_user : null;
	}
	
	public function setStatusUser($value = null)
	{	
		$this->tr_status_user=(int)$value;
		return $this;
	}
	
	/// statusS
	public function getStatusS()
	{
		return $this->trStatus->name;
	}
	
	public function isEntered()
	{
		return $this->tr_status == TrackingStatus::TS_ENTERED;
	}
	
	public function isScan()
	{
		return $this->tr_status == TrackingStatus::TS_SCAN;
	}
	
	public function isScanout()
	{
		return $this->tr_status == TrackingStatus::TS_SCANOUT;
	}
	
	public function isSent()
	{
		return $this->tr_status == TrackingStatus::TS_SENT;
	}
	
	public function isReject()
	{
		return $this->tr_status == TrackingStatus::TS_REJECT;
	}
	
	public function isArchive()
	{
		return $this->tr_archive == self::T_ARCHIVE;
	}
	
	public function isHome()
	{
		return ($this->trTag == null ? false : $this->trTag->home == 1);
	}
	
	public function setEntered()
	{
		$this->status = TrackingStatus::TS_ENTERED;
		return $this;
	}
	
	public function setScan()
	{
		$this->status = TrackingStatus::TS_SCAN;
		return $this;
	}
	
	public function setScanout()
	{
		$this->status = TrackingStatus::TS_SCANOUT;
		return $this;
	}
	
	public function setSent()
	{
		$this->status = TrackingStatus::TS_SENT;
		return $this;
	}
	
	public function setReject()
	{
		$this->status = TrackingStatus::TS_REJECT;
		return $this;
	}

	/// flag
	public function getFlag()
	{
		return $this->tr_flag != null ? $this->tr_flag : 0;
	}
	
	public function setFlag($value = null)
	{	
		$this->tr_flag=(int)$value;
		return $this;
	}
	
	/// ready
	public function getReady()
	{
		return $this->tr_ready != null ? $this->tr_ready : 0;
	}
	
	public function setReady($value)
	{
		$this->tr_ready = (int)$value;
		return $this;
	}

	/// date
	public function setDate($value = null)
	{
		$this->tr_date = $value;
		return $this;
	}	
	
	public function getDate()
	{
		return $this->tr_date;
	}	
	
	public function getDateS()
	{
		return
			date("d.m.Y", strtotime($this->date));
	}	
	
	/*
	/// dateSentSelf
	public function setDateSentSelf($value = null)
	{
		$this->tr_date_sent = $value;
		return $this;
	}	
	
	public function getDateSentSelf()
	{
		return $this->tr_date_sent;
	}	
	
	public function getDateSentSelfS()
	{
		return
			date("d.m.Y", strtotime($this->dateSentSelf));
	}	
	*/
	
	/// archive
	public function getArchive()
	{
		return $this->tr_archive;
	}
	
	public function getArchiveS()
	{
		return $this->isArchive() ? "A" : "";
	}
	
	public function setArchive($value)
	{
		$this->tr_archive = (int)$value;
		return $this;
	}
	
	public function getPrintCommand()
	{
		$PREFIX='';
		$SEPARATOR=';';
		$SUFFIX='#';
		
		$data[] = '11'; 						// field 0 - template Number 11,12,13,etc
		$data[] = $this->trackingNumber;		// field 1 - ORIGINAL TRACKING
		$data[] = $this->internalNumber;		// field 2 - INTERNAL BOX NUMBER + BARCODE
		$data[] = $this->ownerS;				// field 3 - USER
		$data[] = Tag::getNameById($this->tag);	// field 4 - USER TAG
		$data[] = $this->destinationStr;		// field 5 - USER DESTINATION
		$data[] = $this->userRef;				// field 6 - USER REFERENCE + BARCODE
		$data[] = $this->weightS;				// field 7 - WEIGHT
		$data[] = $this->dimS;					// field 8 - DIMENSIONS
		$data[] = $this->methodS;				// field 9 - SHIPPING METHOD (AVIA / SEA)
		$data[] = $this->routeS;				// field 10 - SHIPPING ROUTE (Dnipro, etc)
		
		return $PREFIX.implode($SEPARATOR, $data).$SUFFIX;
	}
	
	public function getVolume()
	{
		return $this->dimX*0.0254*$this->dimY*0.0254*$this->dimZ*0.0254;
	}
	
	public function getFullTrackUrl()
	{
		return (in_array($this->tr_carrier, [1,2,3])) ?
			$this->trCarrier->trackUrl.$this->trackingNumber :
			'#';
	}	
	
	/// dateEntered
	public function getDateEntered()
	{
		return TrackingStatusHistory::findStatusDate($this->id, TrackingStatus::TS_ENTERED);
	}	
	
	/// dateEnteredS
	public function getDateEnteredS()
	{
		return TrackingStatusHistory::findStatusDate($this->id, TrackingStatus::TS_ENTERED, true);
	}	
	
	/// dateScan
	public function getDateScan()
	{
		return TrackingStatusHistory::findStatusDate($this->id, TrackingStatus::TS_SCAN);
	}	
	
	/// dateScanS
	public function getDateScanS()
	{
		return TrackingStatusHistory::findStatusDate($this->id, TrackingStatus::TS_SCAN, true);
	}	
	
	/// dateScanout
	public function getDateScanout()
	{
		return TrackingStatusHistory::findStatusDate($this->id, TrackingStatus::TS_SCANOUT);
	}	
	
	/// dateSent
	public function getDateSent()
	{
		return TrackingStatusHistory::findStatusDate($this->id, TrackingStatus::TS_SENT);
	}	
	
	/// dateSentS
	public function getDateSentS()
	{
		return TrackingStatusHistory::findStatusDate($this->id, TrackingStatus::TS_SENT, true);
	}	
	
	/// dateReject
	public function getDateReject()
	{
		return TrackingStatusHistory::findStatusDate($this->id, TrackingStatus::TS_REJECT);
	}	
	
	/// palletNumber
	public function getPalletNumber()
	{
		return PalletItems::findItem($this->id);
	}	
	
	/// palletNumberS
	public function getPalletNumberS()
	{
		return PalletItems::findItem($this->id, true);
	}	
	
	private function ________other_overloaded___() {}
	
	protected function beforeSave()
    {
		if (parent::beforeSave()) {
			if ($this->status == null) $this->setScan(); //  или setEntered - в зависимости от сценария
			
			//$this->statusDate = new CDbExpression('NOW()');
			$this->statusUser = $this->current_user_id;
			
			if ($this->flag == null) $this->flag=0;
			if ($this->weight == null) $this->weight=0;
			if ($this->total=='') $this->total=NULL;
			// готовность к отправке
			$this->ready = ($this->destination>0 && $this->route>0 && $this->method>0 && $this->owner>0) ? 1 : 0;

			// это потому, что в базе нельзя 0, т.к. не работают Foreign Key
			if ($this->destination == 0) $this->tr_destination=NULL;
			if ($this->route == 0) $this->tr_route=NULL;
			if ($this->method == 0) $this->tr_method=NULL;

			/*
			if ($this->tr_weight=='' || $this->tr_weight==0) $this->tr_weight=NULL;
			if ($this->tr_dimx=='' || $this->tr_dimx==0) $this->tr_dimx=NULL;
			if ($this->tr_dimy=='' || $this->tr_dimy==0) $this->tr_dimy=NULL;
			if ($this->tr_dimz=='' || $this->tr_dimz==0) $this->tr_dimz=NULL;
			*/
			
			return true;
		}
        return false;
    }
	
	protected function afterSave()
    {
        parent::afterSave();
		
		if (!$this->statusChanged) return;
		
		TrackingStatusHistory::writeItem(
			$this->id,
			$this->status,
			$this->tr_status_user);
    }
	
	public static function loadModel($id)
	{
		return static::model()->findByPk($id);
	}
	
	private function ________my_functions_______() {}
	
	// nextInternalNumber
	public function getNextInternalNumber() // getNextUniqueID()
	{
		$PREFIX = ''; //US
		$POSTFIX = 'UX';
		
		$next = (int)self::model()->dbConnection->createCommand()
			->select("nextval('amtx_id')")
			->queryScalar();
			
		$newid = 1000000000+(int)$next;
	
		return $PREFIX.$newid.$POSTFIX;
	}

	public function setNextInternalNumber()
	{
		if ($this->internalNumber == null) $this->internalNumber = $this->nextInternalNumber;
		return $this;
	}
	
	public function getFwdAttributes()
    {
        return [
			'destination'=>$this->destination,
			'route'=>$this->route,
			'method'=>$this->method
		];
    }
	
	private function ________my_STATIC_functions_______() {}
	
	
	public static function trackingFind($tracking)
	{
		$tracking = TrackNumber::trackingCanonize($tracking);
		
		if ($tracking == null) return false;
		
		$id = self::model()->dbConnection->createCommand()
            ->select('tr_id')
            ->from('trackings')
            ->where("tr_tracking = :tracking",				[":tracking"=>$tracking])
            ->orWhere(":tracking like '%'||tr_tracking", 	[":tracking"=>$tracking])
            ->orWhere("tr_tracking like '%'||:tracking", 	[":tracking"=>$tracking])
            ->queryScalar();
			
		return !$id ? false : (int)$id;
	}
	
	public static function trackingScan($tracking)
	{
		if ($found = self::trackingFind($tracking))
			$model=self::loadModel($found);
		else  {
			$model = new self;
			$model->trackingNumber=$tracking;
		}
			
		return $model;
	}
	
	public static function trackingEdit($postdata)
	{
		$id = $postdata['tr_id'];
		
		if ($id == null)
			$tracking = new self;
		else
			$tracking = self::loadModel($id);
		
		$tracking->scenario='scanIn';
		$tracking->attributes=$_POST['Trackings'];
		$tracking->setNextInternalNumber()->setScan();
		
		return $tracking;
	}
	
	public static function getIdByNumber($tracking)
	{
		$tracking = TrackNumber::trackingCanonize($tracking);
		$found = self::model()->findByAttributes(['tr_number'=>mb_strtoupper($tracking)]);
		
		return !$found ? false : (int)$found->id;
	}
	
	public static function getFwdAttributesById($id = null)
    {
		if ($id === null) return [];
		
		$ar = self::model()->findByPk($id);
		
		return !$ar ? [] :
			$ar->getFwdAttributes();
    }
	
	public function __________Excel_Export_________(){}
	
	public function getXlDataStock()
	{
		$this->linesPerGrid=999;
		return $this->searchStock()->getData();
	}
	
	public function getXlDataReady()
	{
		$this->linesPerGrid=999;
		return $this->searchReady()->getData();
	}
	
	public function getXlDataSent()
	{
		$period = $this->ExportExcelBehavior->extraParam;
		$this->linesPerGrid=999;
		return $this->searchSent($period)->getData();
	}

	public function getXlReportHeader()
	{
		return [
			'Item',
			'Tracking',
			'user',
			'ref',
			'weight(kg)',
			'dimension',
			'volume(m3)',
			];
	}
	
	public function getXlReportItem()
	{
		return [
			'number'=>$this->internalNumber,
			'tracking'=>"'".$this->trackingNumber,
			'user'=>$this->ownerS,
			'ref'=>$this->userRef,
			'weight'=>number_format($this->weight,2),
			'dimension'=>$this->dimS,
			'volume'=>number_format($this->volume,3),
		];
	}
	
}
