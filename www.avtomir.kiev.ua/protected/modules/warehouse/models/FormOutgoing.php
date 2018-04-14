<?php

class FormOutgoing extends CFormModel
{
	public $agent;
	public $number;
	public $selection; // array [id, qty, price]
	
	public function rules()
	{
		return [
			['agent, number, selection', 'safe'],
		];
	}

	public function attributeLabels()
	{
		return [
			'agent' =>'Contragent',
			'number' =>'Part Number', 
		];
	}
}