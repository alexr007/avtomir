<?php

class FormModelScanToPallet extends CFormModel
{
	public $pallet;
	public $buffer;
	

	public function attributeLabels()
	{
		return [
			'pallet'=>'Select the pallet', // , where you want to scan boxes
			'buffer'=>'Enter / Scan AMT tracking number',
		];
	}

	public function rules()
	{
		return [
			 ['pallet, buffer',
				'safe'],
		];
	}
}
?>