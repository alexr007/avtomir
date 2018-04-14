<?php

class PriceForm extends CFormModel
{
	public $number;
	
	public function rules()
	{
		return [
			['number', 'safe'],
		];
	}

	public function attributeLabels()
	{
		return [
			'number'=>'Enter Part Number to search',
		];
	}

}