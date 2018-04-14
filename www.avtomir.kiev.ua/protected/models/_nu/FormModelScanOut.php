<?php

class FormModelScanOut extends CFormModel
{
	public $shipment;
	public $methods;
	public $operator;
	public $buffer;

	public function init()
	{
		parent::init();
		$this->shipment = null;
		$this->methods = [];
		$this->operator = null;
		$this->buffer = null;
	}
	
	public function attributeLabels()
	{
		return [
			'shipment'=>'Select the Shipment',
			'methods'=>'Select the Methods',
			'operator'=>'Select the Operator',
			'buffer'=>'Enter / Scan AMT pallet number',
		];
	}

	public function rules()
	{
		return [
			 [
				'shipment, methods, operator, buffer',
				'safe'],
		];
	}
}
?>