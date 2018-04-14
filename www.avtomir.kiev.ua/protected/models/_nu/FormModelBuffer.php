<?php

class FormModelBuffer extends CFormModel
{
	public $buffer;

	public function attributeLabels()
	{
		return [
			'buffer'=>'Enter / Scan tracking number',
		];
	}

}
?>