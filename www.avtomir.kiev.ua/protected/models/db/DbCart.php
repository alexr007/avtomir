<?php

class DbCart extends CActiveRecord
{
	public function tableName()
	{
		return 'cart';
	}

	public function rules()
	{
		return [
			['ct_id, ct_dealer, ct_vendor, ct_number, ct_desc_en, ct_desc_ru, ct_depot, ct_price, ct_weight, ct_volume, ct_quantity, ct_date, ct_comment_user, ct_comment_oper, ct_user, ct_dtype', 'safe'],
			['ct_id, ct_dealer, ct_vendor, ct_number, ct_desc_en, ct_desc_ru, ct_depot, ct_price, ct_weight, ct_volume, ct_quantity, ct_date, ct_comment_user, ct_comment_oper, ct_user, ct_dtype', 'safe', 'on'=>'search'],
		];
	}

	public function relations()
	{
		return [
			'ctDealer' => [self::BELONGS_TO, 'DbDealer', 'ct_dealer'],
			'ctUser' => [self::BELONGS_TO, 'DbUser', 'ct_user'],
			'ctDeliveryType' => [self::BELONGS_TO, 'DbDeliveryType', 'ct_dtype'],
		];
	}

	public function attributeLabels()
	{
		return array(
			'ct_id' => 'id',
			'ct_dealer' => 'Dealer',
			'ct_vendor' => 'Vendor',
			'ct_number' => 'Number',
			'ct_desc_en' => 'Desc En',
			'ct_desc_ru' => 'Desc Ru',
			'ct_depot' => 'Depot',
			'ct_price' => 'Price',
			'ct_weight' => 'Weight',
			'ct_volume' => 'Volume',
			'ct_quantity' => 'Quantity',
			'ct_date' => 'Date',
			'ct_comment_user' => 'Comment User',
			'ct_comment_oper' => 'Comment Oper',
			'ct_user' => 'User',
		);
	}

	//	'dataProvider'=>$dbCart->searchByUser(new RuntimeUser()),
	public function searchByUser(IRuntimeUser $user)
	{
		//$criteria=(new CDbCriteria();
		//$criteria->compare('ct_user',$user->id());

		$criteria=(new CDbCriteria())->compare('ct_user',$user->id());
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function search($addCriteria = null)
	{
		$criteria=new CDbCriteria;

		$criteria->compare('ct_id',$this->ct_id);
		$criteria->compare('ct_dealer',$this->ct_dealer);
		$criteria->compare('ct_vendor',$this->ct_vendor,true);
		$criteria->compare('ct_number',$this->ct_number,true);
		$criteria->compare('ct_desc_en',$this->ct_desc_en,true);
		$criteria->compare('ct_desc_ru',$this->ct_desc_ru,true);
		$criteria->compare('ct_depot',$this->ct_depot,true);
		$criteria->compare('ct_price',$this->ct_price,true);
		$criteria->compare('ct_weight',$this->ct_weight,true);
		$criteria->compare('ct_volume',$this->ct_volume,true);
		$criteria->compare('ct_quantity',$this->ct_quantity);
		$criteria->compare('ct_date',$this->ct_date,true);
		$criteria->compare('ct_comment_user',$this->ct_comment_user,true);
		$criteria->compare('ct_comment_oper',$this->ct_comment_oper,true);
		$criteria->compare('ct_user',$this->ct_user);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public static function loadById($id)
	{
		return self::model()->findByPk($id);
	}
	
	
	public function fillWith($data)
	{
		if (!is_array($data))
			throw new CException("Configuration options must be an array!");
		
		$allowedFields = ['ct_dealer','ct_vendor','ct_number','ct_desc_en','ct_desc_ru',
			'ct_depot','ct_price','ct_weight','ct_volume','ct_quantity','ct_comment_user','ct_comment_oper','ct_dtype',
			];
		
		foreach ($data as $key=>$value)
			if (in_array($key, $allowedFields))
				$this->{$key} = $value;
		
		return $this;
	}
	
	public function getId()
	{
		return $this->ct_id;
	}	
	
	public function getDealerS()
	{
		return $this->ctDealer->name;
	}	
	
	public function getDTypeS()
	{
		return $this->ctDeliveryType->name;
	}	
	
	public function getUserS()
	{
		return $this->ctUser->name;
	}	
	
	public function getDateS()
	{
		return (new DateFormatted($this->ct_date))->date();
	}	
	
	public function getFlagCss()
	{
		$css = new FlagCss($this->ct_dealer);
		return $css->value();
	}
	
	public function beforeSave()
	{
        if (parent::beforeSave()) {
			$this->ct_date = new DbCurrentTimestamp();
			$user = new RuntimeUser();
			$this->ct_user = $user->id();
			return true;
		}
		return false;
	}
	
}
