<?php

class DbNewOrderNumber {

	const ORDER_NUMBER_PREFIX = 'AM';
	
	public function nextValue()
	{
		$next = (int)Yii::app()->db->createCommand()
			->select("nextval('order_number')")
			->queryScalar();
			
		return self::ORDER_NUMBER_PREFIX.$next;
	}
}
