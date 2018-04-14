<?php

class CartDeleteByUser {
	
	public function __construct(IRuntimeUser $user)
	{
		if ($user->isGuest()) return false;
		
		Yii::app()->db->createCommand()
			->delete('cart','ct_user=:uid' ,['uid'=>$user->id()]);
		
	}
}
