<?php

class FoundResultsDeleteOld {
	
	public function __construct()
	{
		// удаляем все проценки старее часа
        $time_limit = "1H";
		$since = new DateTime();
        $since->sub(new DateInterval("PT{$time_limit}"));
		
		Yii::app()->db->createCommand()
			->delete('part_price','pp_date < :since' ,[':since'=>$since->format('Y-m-d H:i:s')]);
	}
}
