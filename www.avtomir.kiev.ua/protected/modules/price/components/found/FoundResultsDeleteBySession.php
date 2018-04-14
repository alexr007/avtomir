<?php

class FoundResultsDeleteBySession {
	
	public function __construct(IRuntimeSession $session)
	{
		Yii::app()->db->createCommand()
			->delete('part_price','pp_session=:sid' ,['sid'=>$session->id()]);
		
	}
}
