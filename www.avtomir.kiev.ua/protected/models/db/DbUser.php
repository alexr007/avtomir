<?php

class DbUser extends CUser
{

	protected function afterSave()
	{
		parent::afterSave();
		if ($this->isNewRecord) {
			// если он новый - то ему роль client
			$auth=Yii::app()->authManager;
			$auth->assign('client', $this->u_id);
			$auth->save();
			// и создаем чистый профиль
			UserProfile::createCleanProfile($this->u_id);
		} 
		return true;
	}
			
}
