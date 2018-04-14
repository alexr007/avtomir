<?php

class UserTags extends Tag {
	
    public static function tagsCount($id = null)
    {
		$user_id = $id ? $id : Yii::app()->user->id;
		
		$count = (int)self::model()->dbConnection->createCommand()
            ->select('COUNT(*)')
            ->from('tags')
            ->where('tg_user = :user', 
					[':user'=>$user_id])
            ->queryScalar();
			
		return $count;
    }
	
    public static function generateTag($id, $login){
		// ALEX
		$PREFIX = mb_strtoupper(mb_substr($login,0,3));	//ALE
		$SUFFIX = mb_strtoupper(mb_substr($login,-1,1)); //X
		$new_id = 1000+$id;
		
		return $PREFIX.$new_id.$SUFFIX;
    }
	
	public static function createInitialTags($id = null)
	{
		$user_id = $id ? $id : Yii::app()->user->id;
		
		Yii::app()->settings->deletecache();
		$TagCountDef = Yii::app()->settings->get('user', 'TagCountDef');
						
		while ( self::tagsCount() < $TagCountDef) {
			static::createNewTag();
		}
	}
	
	// TAG создается после первого логина
	public static function createNewTag($id = null)
	{
		$user_id = $id ? $id : Yii::app()->user->id;
		// исправить !!! работает только для залогиненого пользователя
		$login = Yii::app()->user->name;
		
		Yii::app()->settings->deletecache();
		$TagCountMax = Yii::app()->settings->get('user', 'TagCountMax');
		
		if (self::tagsCount($user_id)>=$TagCountMax) return false;
		
		$t = new UserTags;
		$t->save(false);
		// получаем pk вставленной записи
		$pk = $t->getPrimaryKey(); 
		$t->tg_tag = self::generateTag($pk, $login);
		$t->tg_user = $user_id; // by default 
		$t->save();
		return true;
	}
	
	public function defaultScope() 
	{
		$user_id =	Yii::app()->user->id ? 
					Yii::app()->user->id : 0;
		
		return [
			'condition' => "tg_user = $user_id"
		];
	}
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
		
}

