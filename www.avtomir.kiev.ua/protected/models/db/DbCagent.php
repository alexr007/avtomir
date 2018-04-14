<?php

class DbCagent extends LActiveRecord
{
	public static $list_key_field = 'ca_id';	// id;
	public static $list_name_field = 'ca_name';	// 'name';
	public static $list_sort_field = 'ca_id';	// 'id';
	
	public $userName;
	/*
	public function getDbConnection()
	{
        return Yii::app()->db2;
    }
	 * 
	 */

	public function tableName()
	{
		return 'cagents';
	}

	public function rules()
	{
		return array(
			array('ca_id, ca_name, ca_type, ca_userid, userNameS', 'safe'),
			array('ca_id, ca_name, ca_type, ca_userid, userNameS', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return [
			'caUser' => array(self::BELONGS_TO, 'DbUser', 'ca_userid'),
			'caType' => array(self::BELONGS_TO, 'DbCagentType', 'ca_type'),
			'incomings' => array(self::HAS_MANY, 'DbIncoming', 'in_cagent'),
			'warehouseOrders' => array(self::HAS_MANY, 'DbWarehouseOrder', 'wo_cagent'),
			'warehouseCarts' => array(self::HAS_MANY, 'DbWarehouseCart', 'wc_cagent'),
		];
	}

	public function attributeLabels()
	{
		return array(
			'ca_id' => 'id',
			'ca_name' => 'Name',
			'ca_type' => 'Type',
			'ca_userid' => 'Linked User',
			'userNameS' => 'Linked User Login',
			'typeS' => 'Type',
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('ca_id',$this->ca_id);
		$criteria->compare('upper(ca_name)',  mb_strtoupper($this->ca_name),true);
		$criteria->compare('ca_type',$this->ca_type);
		$criteria->compare('ca_userid',$this->ca_userid);
		
		if ($this->userName) {
			$criteria->with[] = 'caUser';
			$criteria->compare('upper(u_login)', mb_strtoupper($this->userName), true);
		}
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function beforeSave()
	{
        if (parent::beforeSave()) {
			if (in_array($this->ca_userid, ['','0'])) $this->ca_userid = null;
			return true;
		}
		return false;
	}
	
	public static function listDataIncoming($params = [])
	{
		return static::listData($params, '(((ca_type >> 0) & 1) = 1)'); // 1й бит справа
	}
	
	public static function listDataOutgoing($params = [])
	{
		return static::listData($params, '(((ca_type >> 1) & 1) = 1)'); // 2й бит справа
	}
	
	public function getId()
	{
		return $this->ca_id;
	}
	
	public function getName()
	{
		return $this->ca_name;
	}
	
	public function getUserId()
	{
		return $this->ca_userid 
			? $this->ca_userid 
			: 0;
	}
	
	public function getTypeS()
	{
		return $this->ca_type == null
				? ""
				: $this->caType->name;
	}
	
	public function getUserNameS()
	{
		return $this->ca_userid == null
				? ""
				: $this->caUser->name;
	}
	
	public function setUserNameS($value)
	{
		$this->userName = $value;
	}
	
	public function getCurrentIdName() {
		return $this->ca_userid
			? [$this->ca_userid => $this->userNameS]
			: [];
	}
}
