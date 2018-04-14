<?php

/*
	pallet_items

	@property integer $pi_id
	@property integer $pi_pallet
	@property integer $pi_item
	@property date $pi_date
	@property integer $pi_user

	@property Pallet $piPallet
	@property Trackings $piItem
*/
	
class PalletItems extends CActiveRecord
{
	const ERR_SUCCESS = 'success';
	const ERR_NOTICE = 'notice';
	const ERR_ERROR = 'error';
	
	public $linesPerGrid;
	
	private $_error_code; // success | error | notice
	private $_error_message;
	
	public function tableName()
	{
		return 'pallet_items';
	}

	public function rules()
	{
		return [
			['pi_pallet, pi_item, pi_date, pi_user', 'safe'],
			['pi_id, pi_pallet, pi_item, pi_date, pi_user', 'safe', 'on'=>'search'],
		];
	}

	public function relations()
	{
		return array(
			'piPallet' => array(self::BELONGS_TO, 'Pallet', 'pi_pallet'),
			'piItem' => array(self::BELONGS_TO, 'Trackings', 'pi_item'),
			'piUser' => array(self::BELONGS_TO, 'User', 'pi_user'),
		);
	}

	public function getPiItemKey()
	{
		return $this->piItem->tr_id;
	}
	
	public function attributeLabels()
	{
		return array(
			'pi_id' => 'id',
			'pi_pallet' => 'PI Pallet',
			'pi_item' => 'PI item',
			'pi_date' => 'PI date',
			'pi_user' => 'PI user',
		);
	}

	public function init()
	{
		parent::init();
		$this->linesPerGrid = 20;
	}
	
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('pi_id',$this->pi_id);
		$criteria->compare('pi_pallet',$this->pi_pallet);
		$criteria->compare('pi_item',$this->pi_item);
		$criteria->compare('pi_date',$this->pi_date);
		$criteria->compare('pi_user',$this->pi_user);

		return new CActiveDataProvider($this, [
			'criteria'=>$criteria,
			'pagination'=>($this->linesPerGrid==999 ? 
							false : 
							['pageSize'=>$this->linesPerGrid]), // hack for no pagination
			]
		);
	}
	
	protected function beforeSave()
    {
        if (parent::beforeSave()) {
			$this->pi_date = new CDbExpression('NOW()');
			$this->pi_user = Yii::app()->user->id;
			return true;
		}
		return false;
    }

	public function defaultScope() 
	{
		return [
			'order'=>'pi_date desc',
		];
	}
	
	// scope
	public function byPallet($pallet = null)
	{
		if ($pallet === null) 
			$this->getDbCriteria()->mergeWith([
				'condition'=>'1=2',
			]);
		else
			$this->getDbCriteria()->mergeWith([
				'condition'=>'pi_pallet='.(int)$pallet,
			]);
			
		return $this;		
	}
	
    public function scopes()
    {
		return [
            'recently'=>[
				'order'=>'pi_date desc',
//				'limit' => 10,
            ],
        ];
    }

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function ___________static_______(){}
	
	public static function volumeInPallet($pallet = null)
	{
		if ($pallet === null) return false;
		$total = Yii::app()->db->createCommand()
					->select('sum(tr_dimx*0.0254*tr_dimy*0.0254*tr_dimz*0.0254)')
					->from('pallet_items')
					->join('trackings','tr_id=pi_item')
					->where('pi_pallet=:pallet',[':pallet'=>$pallet])
					->queryScalar();
					
		return $total;
	}
	
	public static function weightInPallet($pallet = null)
	{
		if ($pallet === null) return false;
		$total = Yii::app()->db->createCommand()
					->select('sum(tr_weight)')
					->from('pallet_items')
					->join('trackings','tr_id=pi_item')
					->where('pi_pallet=:pallet',[':pallet'=>$pallet])
					->queryScalar();
					
		return $total;
	}

	public static function countInPallet($pallet = null)
	{
		if ($pallet === null) return false;
		
		$count = self::model()->countByAttributes(['pi_pallet'=>$pallet]);
	
		return (int)$count;
	}

	public static function isEmptyPallet($pallet = null)
	{
		if ($pallet === null) return false;
		
		return self::countInPallet($pallet) == 0;
	}
	
	public static function checkItemInPallet($item = null, $pallet = null)
	{
		$count = self::model()->countByAttributes(['pi_item'=>$item,'pi_pallet'=>$pallet]);
		return $count > 0;
	}

	public static function findItem($item = null, $asString = false)
	{
		if ($item == null) return false;
		$found = self::model()->findByAttributes(['pi_item'=>$item]);
		
		return ($found) ? 
			($asString ? $found->piPallet->number : $found->pi_pallet) :
			($asString ? "" : false)  ;
	}
	
	public static function addItemToPallet($item = null, $pallet = null)
	{
		if ($item == null || $pallet == null) return false;
		
		if (self::checkItemInPallet($item, $pallet)) return true; // есть в этой палетте
		if (self::findItem($item)) return false; // есть в другой палетте
		
		$pi = new self;
		
		$pi->isNewRecord = true;
		$pi->pi_item = (int)$item;
		$pi->pi_pallet = (int)$pallet;
		
		if (!$pi->save()) return false; // ошибка БД
		
		// теперь обновляем статус коробки, которую положили на паллет.
		return Trackings::model()->findByPk($item)->setScanout()->save(); 
	}
	
	public static function removeItemFromPallet($item = null)
	{
		if ($item === null) return false;
		
		$pi = self::model()->findByAttributes(['pi_item'=>$item]);
		if (!$pi) return false;

		if (!$pi->delete()) return false; // ошибка БД;
		
		// теперь обновляем статус коробки, которую положили на паллет.
		return Trackings::model()->findByPk($item)->setScan()->save(); 
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
	
	public function addToPallet($pallet_id = null, $buffer_item = null)
	{
		// $item - amtx (1xxxxxxxUX) number
		
		$this->errorCode=self::ERR_ERROR;
		
		if ($pallet_id == null){
			$this->errorMessage="You must select pallet to scan";
			return false;
		}
		
		if ($buffer_item == null){
			$this->errorMessage="Please scan/enter AMT number before press button";
			return false;
		}

		$item = Trackings::getIdByNumber($buffer_item);

		// если коробка не найдена
		if (!$item)	{
			$this->errorMessage="Item <b>$buffer_item</b> not found in database. contact administrator";
			return false;
		}

		// если коробка имеет статус HOME
		if (Trackings::model()->findByPk($item)->isHome()) {
			$this->errorMessage="Item <b>$buffer_item</b> is HOME item n/a to Scan";
			return false;
		}
		
		// если коробка присутствует на ЭТОЙ палетте
		if (PalletItems::checkItemInPallet($item, $pallet_id)) {
			$this->errorMessage="Item <b>$buffer_item</b> already on THIS Pallet";
			return false;
		}
	
		// если коробка присутствует на ДРУГОЙ палетте
		if (PalletItems::findItem($item)) {
			$this->errorMessage="Item <b>$buffer_item</b> already on OTHER Pallet";
			return false;
		}
		
		// если у коробки не заполнего поле Ready
		if (Trackings::model()->findByPk($item)->ready !=1) {
			$this->errorMessage="Item <b>$buffer_item</b> not ready to scan to pallet!";
			return false;
		}
		
		$empty = PalletItems::isEmptyPallet($pallet_id);
			
		// если палетта не пустая -> проверка соответствия параметров сканированой коробки параметрам используемой паллеты
		if (!$empty) 
//			if (!Pallet::checkPalletAttributes($pallet_id, Trackings::getFwdAttributesById($item))) {
			if (Pallet::getFwdAttributesById($pallet_id) != Trackings::getFwdAttributesById($item)) {
				// если у коробки отличаются атрибуты паллеты
				$this->errorMessage="Box $buffer_item attributes DIFFERENT from the selected pallet.";
				return false;
			}
		
		// если соответствует -> то добавление сканированой коробки в паллету
		if (!PalletItems::addItemToPallet($item, $pallet_id)) {
			$this->errorMessage="Error while DB operation. contact administrator";
			return false;
		}

		// если ПУСТАЯ - копирум параметры первой коробки в параметры паллеты
		if ($empty)
			Pallet::assignPallet($pallet_id);
		
		$this->errorCode=self::ERR_SUCCESS;
		$this->errorMessage="Item <b>$buffer_item</b> Successfully added to Pallet";
		return true;
	}
	
	public function removeFromPallet($pallet_id = null, $item = null)
	{
		$this->errorCode=self::ERR_ERROR;
		
		if ($pallet_id == null){
			$this->errorMessage="You must select pallet to scan";
			return false;
		}
		
		if ($item == null){
			$this->errorMessage="You must select item to removce from pallet";
			return false;
		}
		
		// удаляем номер коробки из паллеты
		if (!PalletItems::removeItemFromPallet($item)) {
			$this->errorMessage="Error while DB operation. contact administrator";
			return false;
		}
		
		$this->errorCode=self::ERR_SUCCESS;
		$this->errorMessage='Box <b>'.Trackings::model()->findByPk($item)->internalNumber.'</b> Removed from Pallet';
		return true;
	}
	
	public function getXlReportItem()
	{
		return $this->piItem->getXlReportItem();
	}
	
}
