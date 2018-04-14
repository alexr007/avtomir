<?php

class FormIncoming extends CFormModel
{
	public $agent;
	public $vendor;
	public $number;
	public $qty;
	public $price;
	public $weight;
	
	public function rules()
	{
		return [
			['agent, vendor, number, qty, price, weight', 'safe'],
		];
	}

	public function attributeLabels()
	{
		return [
			'agent' =>'Contragent',
			'vendor' =>'Vendor', 
			'number' =>'Part Number', 
			'qty' =>'Qty', 
			'price' =>'Price',
			'weight' =>'Weight',
		];
	}
}