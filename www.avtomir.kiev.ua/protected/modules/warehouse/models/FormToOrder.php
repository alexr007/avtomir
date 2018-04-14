<?php

class FormToOrder extends CFormModel
{
	public $cagent;
	public $selection; // array [id, 1-yes, absent-no]
	
	public function rules()
	{
		return [
			['cagent, selection', 'safe'],
		];
	}
}