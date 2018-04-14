<?php

class Tag extends LActiveRecord
{
	public static $list_key_field='tg_id';
	public static $list_name_field='tg_tag';
	public static $list_sort_field='tg_id';
	
	const TF_HOME = FlagBehavior::PF_1;
	
	public function tableName()
	{
		return 'tags';
	}

	public function rules()
	{
		return array(
			['home',
				'safe'],
			array('tg_tag, tg_user, tg_date, tg_comment, tg_flag', 'safe'),
			array('tg_id,tg_tag,tg_user,tg_date,tg_comment, tg_flag', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'tgUser' => array(self::BELONGS_TO, 'User', 'tg_user'),
			'trackings' => array(self::HAS_MANY, 'Trackings', 'tr_tag'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'tg_id' => 'id',
			'tg_tag' => 'TAG',
			'tg_user' => 'User',
			'tg_date' => 'Created Date',
			'tg_comment' => 'Comment',
		);
	}

	public function behaviors() {
		return [
			'FlagBehavior' => [
				'class' => 'application.components.behavior.TagBehavior',
			],
		];
	}
	
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('tg_id',$this->tg_id);
		$criteria->compare('lower(tg_tag)',mb_strtolower($this->tg_tag),true);
		$criteria->compare('tg_user',$this->tg_user);
		$criteria->compare('tg_date',$this->tg_date,true);
		$criteria->compare('lower(tg_comment)',mb_strtolower($this->tg_comment),true);
		
		if ($this->tg_flag != NULL){
			$bit=FlagBehavior::bitNumber($this->tg_flag);
			$criteria->compare("(tg_flag>>$bit)&1",1);
		}

		return new CActiveDataProvider($this, [
			'criteria'=>$criteria,
		]);
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /// id
	public function getId()
    {
		return $this->tg_id;
    }
	
    /// tag
	public function getTag()
    {
		return $this->tg_tag;
    }
	
    /// user
	public function getUser()
    {
		return $this->tg_user;
    }
	
    /// name
	public function getName()
    {
		return $this->tag;
    }

    /// userNameS
	public function getUserNameS()
    {
		return $this->user == null ? "" : $this->tgUser->name;
    }

	public function getDateS()
    {
		return date("Y-m-d G:i", strtotime($this->tg_date));
    }
	
	public function getFlag()
	{
		return (int)$this->tg_flag;
	}
	
	public function setFlag($value = null)
	{	
		$this->tg_flag=(int)$value;
		return $this;
	}
	
	protected function beforeSave()
    {
        if ($this->isNewRecord) {
			$this->tg_date = new CDbExpression('NOW()') ;
        }
        return parent::beforeSave();
    }
	
	public static function getUserByTag($tag)
	{
		$t = Tag::model()->findByAttributes(['tg_tag'=>$tag]);
		if ($t == null) return null;
		return $t->tg_user;
	}
	
	public static function getUserByTagId($tag)
	{
		$t = Tag::model()->findByPk($tag);
		if ($t == null) return null;
		return $t->tg_user;
	}
	
	public static function getTagCountByUser($user)
	{
		return 
			(int)self::model()->dbConnection->createCommand()
				->select('COUNT(*)')
				->from('tags')
				->where('tg_user = :user', 
						[':user'=>$user])
				->queryScalar();
	}
	
	public static function getUserTags($user = null)
	{
		if ($user === null) return false;
		$t = Tag::model()->findAllByAttributes(['tg_user'=>$user]);
		if ($t === null) return false;
			else return $t;
	}
}
