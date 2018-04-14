<?php

class DbUsersNotAssigned extends LActiveRecord
{
	public static $list_key_field = 'u_id';	// id;
	public static $list_name_field = 'u_login';	// 'name';
	public static $list_sort_field = 'u_login';	// 'id';
	
	public function tableName()
	{
		return 'users_not_assigned';
	}
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
}
