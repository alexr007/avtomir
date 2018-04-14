<?php

class DbWebService extends CActiveRecord
{
	const TOKEN = 'token';
	
	public function tableName()
	{
		return 'web_service';
	}

	public function rules()
	{
		return [
			['ws_id, ws_name, ws_enable, ws_connect, ws_path, ws_tmp, ws_type, ws_functions', 'safe'],
 		];
	}

	public function relations()
	{
		return [];
	}

	public function attributeLabels()
	{
		return [
			'ws_id' => 'id',
            'ws_name' => 'Name',
            'ws_enable' => 'Enable',
            'ws_connect' => 'Connect',
            'ws_path' => 'Path',
            'ws_tmp' => 'Tmp',
            'ws_type' => 'Type',
            'ws_functions' => 'Functions',
		];
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getJsonValueByField($tableField, $JsonKey)
	{
		$data = json_decode($this->$tableField);
		$filed=$JsonKey;
		
		return isset($data->$filed) ? $data->$filed : '';
	}
	
	public function getToken()
	{
		return $this->getJsonValueByField('ws_tmp',self::TOKEN);
	}
	
	public function getPathToken()
	{
		return $this->getJsonValueByField('ws_functions', '$token');
	}
	
	public function getPathPrice()
	{
		return $this->getJsonValueByField('ws_functions', 'price');
	}
	
	public function getPathMain()
	{
		return $this->getJsonValueByField('ws_path', 'path');
	}
	
	public function setToken($value = null)
	{
		$data = [self::TOKEN=>$value];
		$this->ws_tmp = json_encode($data);
		
		return $this;
	}
	
}
