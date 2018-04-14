<?php

class DbPartSearchHistory extends CActiveRecord implements IPutToHistory
{
	public function tableName()
	{
		return 'part_search_history';
	}

	public function rules()
	{
		return [
			array('psh_id, psh_user, psh_search, psh_date', 'safe'),
			array('psh_id, psh_user, psh_search, psh_date', 'safe', 'on'=>'search'),
		];
	}

	public function relations()
	{
		return [
			'pshUser' => [self::BELONGS_TO, 'DbUser', 'psh_user'],
		];
	}

	public function attributeLabels()
	{
		return array(
			'psh_id'=>'id', 
			'psh_user'=>'user', 
			'psh_search'=>'Part Number Searched', 
			'psh_date'=>'date',
		);
	}
	
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('psh_id',$this->psh_id);
		$criteria->compare('psh_user',$this->psh_user);
		$criteria->compare('psh_date',$this->psh_date);
		$criteria->compare('upper(psh_search)',  mb_strtoupper($this->psh_search),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function beforeSave()
	{
        if (parent::beforeSave()) {
			$this->psh_date = new DbCurrentTimestamp();
			return true;
		}
		return false;
	}
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	private function getUser() {
		return $this->psh_user;
	}
	
	private function setUser($value) {
		$this->psh_user = $value;
		return $this;
	}

	private function getSearch() {
		return $this->psh_search;
	}
	
	private function setSearch($value) {
		$this->psh_search = $value;
		return $this;
	}
	
	public function putToHistory($value, IRuntimeUser $user)
	{
		if ($value === null) return false;
		
		$item = new self;
		return 
			$item->setUser($user->id())
				->setSearch($value)
				->save();
	}
	
	public function defaultScope() 
	{
		return [
			'order'=>'psh_date desc',
		];
	}
	
	public function getDate()
	{
		return (new DateFormatted($this->psh_date, "d.m.Y H:m:s "))->date();
	}
	
}