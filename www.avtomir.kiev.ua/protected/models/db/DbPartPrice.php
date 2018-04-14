<?php

class DbPartPrice extends CActiveRecord
{
	
	public function tableName()
	{
		return 'part_price';
	}

	public function rules()
	{
		return [
			['pp_id, pp_dealer, pp_vendor, pp_number, pp_replacenumber, pp_desc_en, pp_desc_ru, pp_depot, pp_qty, pp_price, pp_weight, pp_volume, pp_session, pp_date', 'safe'],
			['pp_id, pp_dealer, pp_vendor, pp_number, pp_replacenumber, pp_desc_en, pp_desc_ru, pp_depot, pp_qty, pp_price, pp_weight, pp_volume, pp_session, pp_date', 'safe', 'on'=>'search'],
		];
	}

	public function relations()
	{
		return [
			'ppDealer' => [self::BELONGS_TO, 'DbDealer', 'pp_dealer'],
		];
	}

	public function attributeLabels()
	{
		return array(
			'pp_id' => 'id',
			'pp_user' => 'User',
			'pp_dealer' => 'Dealer',
			'pp_vendor' => 'Vendor',
			'pp_number' => 'Number',
			'pp_replacenumber' => 'New number',
			'pp_desc_en' => 'Desc En',
			'pp_desc_ru' => 'Desc Ru',
			'pp_depot' => 'Depot',
			'pp_qty' => 'Qty',
			'pp_price' => 'Price',
			'pp_weight' => 'Weight',
			'pp_volume' => 'Volume',
		);
	}

	public function searchBySession(IRuntimeSession $session)
	{
		$criteria=new CDbCriteria;

		$criteria->compare('pp_session',$session->id());
		
		$criteria->compare('pp_id',$this->pp_id);
		$criteria->compare('pp_dealer',$this->pp_dealer);
		//$criteria->compare('pp_vendor',$this->pp_vendor,true);
		//$criteria->compare('pp_number',$this->pp_number,true);
		//$criteria->compare('pp_desc_en',$this->pp_desc_en,true);
		//$criteria->compare('pp_desc_ru',$this->pp_desc_ru,true);
		//$criteria->compare('pp_depot',$this->pp_depot,true);
		//$criteria->compare('pp_qty',$this->pp_qty);
		//$criteria->compare('pp_price',$this->pp_price,true);
		//$criteria->compare('pp_weight',$this->pp_weight,true);
		//$criteria->compare('pp_volume',$this->pp_volume,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination'=>false,
            //'pagination'=>['pageSize'=>22],
		));
	}
	
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('pp_id',$this->pp_id);
		$criteria->compare('pp_dealer',$this->pp_dealer);
		//$criteria->compare('pp_vendor',$this->pp_vendor,true);
		//$criteria->compare('pp_number',$this->pp_number,true);
		//$criteria->compare('pp_desc_en',$this->pp_desc_en,true);
		//$criteria->compare('pp_desc_ru',$this->pp_desc_ru,true);
		//$criteria->compare('pp_depot',$this->pp_depot,true);
		//$criteria->compare('pp_qty',$this->pp_qty);
		//$criteria->compare('pp_price',$this->pp_price,true);
		//$criteria->compare('pp_weight',$this->pp_weight,true);
		//$criteria->compare('pp_volume',$this->pp_volume,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getId()
	{
        return $this->pp_id;
	}
	
	public function getDealerS()
	{
        return $this->ppDealer->showAs;
	}
	
	public function getFlagCss()
	{
		$css = new FlagCss($this->pp_dealer);
		return $css->value();
	}
	
	public function beforeSave()
	{
        if (parent::beforeSave()) {
			$this->pp_date = new DbCurrentTimestamp();
			return true;
		}
		return false;
	}
	
	public function getReplacementPriceUrl()
	{
		return '?PriceForm%5Bnumber%5D='.$this->pp_replacenumber;
	}
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
}
