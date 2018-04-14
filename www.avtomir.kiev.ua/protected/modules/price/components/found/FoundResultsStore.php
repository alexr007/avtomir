<?php

class FoundResultsStore {
	
	public function __construct(CList $data, IRuntimeSession $session)
	{
		// удаляем все проценки старее часа
		new FoundResultsDeleteOld();
		// удаляем шо было с текущей сессии
		new FoundResultsDeleteBySession($session);
		
		// кладем новое
		foreach ($data as $item)
			Yii::app()->db->createCommand()
				->insert('part_price',['pp_session'=>$session->id(),'pp_date'=>'NOW()']+$item->columns());
	}
	
}
