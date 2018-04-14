<?php

/**
 * This is the model class for table "user_profile".
 *
 * The followings are the available columns in table 'user_profile':
 * @property integer $up_id
 * @property integer $up_user
 * @property integer $up_field
 * @property string $up_value
 *
 * The followings are the available model relations:
 * @property Users $upUser
 * @property UserProfileFields $upField
 */
class UserProfile extends CActiveRecord
{
	private $_profile = null;
	
	public function tableName()
	{
		return 'user_profile';
	}

	public function rules()
	{
		return [
			array('up_user, up_field', 'numerical', 'integerOnly'=>true),
			array('up_value', 'safe'),
			array('up_id, up_user, up_field, up_value', 'safe', 'on'=>'search'),
		];
	}

	public function relations()
	{
		return [
			'upUser' => [self::BELONGS_TO, 'DbUser', 'up_user'],
			'upField' => [self::BELONGS_TO, 'UserProfileFields', 'up_field'],
		];
	}

	public function attributeLabels()
	{
		return [
			'up_id' => 'id',
			'up_user' => 'User',
			'up_field' => 'Field',
			'up_value' => 'Value',
		];
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('up_id',$this->up_id);
		$criteria->compare('up_user',$this->up_user);
		$criteria->compare('up_field',$this->up_field);
		$criteria->compare('up_value',$this->up_value,true);

		$criteria->join = 'JOIN user_profile_fields ON upf_id=up_field';
		$criteria->compare('upf_enable',1);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function defaultScope() {
        return [
            'order'=>'up_user asc',
        ];
    }
	/*
    public function scopes()
    {
		
		return [
            'enabled'=>[
				//'condition'=>"upf_enable=1"
				//'condition'=>"$this->upField->upf_enable = 1",
				//'condition'=>"1=1",
				],
        ];
    }
	*/
	
	public function getDestination($id = null)
	{
		if ($this->_profile == null) $this->loadProfile($id);
		//VarDumper::dump($this->_profile);
		foreach ($this->_profile as $profile_item)
			if ($profile_item['upf_name'] == 'destination')
				return $profile_item['up_value'];
	}
	
	public function getDefaultRoute($id = null)
	{
		if ($this->_profile == null) $this->loadProfile($id);
		foreach ($this->_profile as $profile_item)
			if ($profile_item['upf_name'] == 'default_route')
				return $profile_item['up_value'];
	}
	
	public function getDefaultMethod($id = null)
	{
		if ($this->_profile == null) $this->loadProfile($id);
		foreach ($this->_profile as $profile_item)
			if ($profile_item['upf_name'] == 'default_method')
				return $profile_item['up_value'];
	}
	
	// просто массив моделей из таблицы по ID пользователя
	private function loadProfile($id = null){
		if ($id == null) $id = Yii::app()->user->id;
		$this->_profile = self::model()->getProfileExtra($id);
		return true;
	}
	
	// просто массив моделей из таблицы по ID пользователя
	public static function getProfile($id = null){
		if ($id == null) $id = Yii::app()->user->id;
		return self::model()->findAllByAttributes(['up_user'=>$id]);
	}
	
	// одно поле по ID пользователя и NAME поля
	public static function getValueByUserField($u_id = null, $field = null)
	{
		if ($u_id == null || $field == null) return false;
		$v = self::model()->findByAttributes(['up_user'=>$u_id, 'up_field'=>UserProfileFields::getIdByName($field)]);
		if ($v == null) return 0;
			else return $v->up_value;
	}
	
	// весь профиль с наваниями, описанием полей, их значениями по ID пользователя
	public static function getProfileExtra($id = null)
	{
		if ($id == null) return false;
		$profile = self::model()->dbConnection
			->createCommand("select up_id, upf_id, upf_name, upf_description, up_value".
							" from user_profile_fields".
							" left outer join user_profile on upf_id=up_field and up_user=:id".
							" where upf_enable=1 and upf_show=1".
							" order by upf_order")
			->bindParam("id", $id, PDO::PARAM_INT)
			->queryAll();
			
		if ($profile == null) return false;
		return $profile;
	}
	
	// весь профиль name=>value по ID пользователя
	public static function getProfileNVById($id = null)
	{
		$profile = self::getProfileExtra($id);
		$r=[];
		
		foreach ($profile as $item) {
			$r[$item['upf_name']] = $item['value'];
		}
		
		return $r;
	}
	
	// проверить - не пустой ли профиль ?
	public static function isProfileExists($id = null)
	{
		if ($id === null) return false;
		if (self::getProfile($id)) return true;
			else return false;
	}
	
	// создать пустой профиль для пользователя
	// пустой профиль создается после создания User'a или при заходе в его закладу UserProfile
	public static function createCleanProfile($id = null)
	{
		if ($id === null) return false;
		if (self::isProfileExists($id)) return false; 

		$cmd=self::model()->dbConnection
			->createCommand("insert into user_profile(up_user, up_field, up_value) select :id, upf_id, upf_default from user_profile_fields")
			->bindValues([":id"=>$id]);
			
		return $cmd->execute();
	}
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	// используется для получения значения вместо $this->up_value в тех случаях когда это Lookup поле
	public function getFieldValue()
	{
		$value = $this->up_value;
		switch ($this->upField->upf_name) {
			case "country" :
				return Countries::getNameById((int)$value);
			case "destination" :
				return Destinations::getNameById((int)$value);
			case "default_method" :
				return Shippingmethods::getNameById((int)$value);
			case "default_route" :
				return Operators::getNameById((int)$value);
			case "timezone" :
				return Timezones::getNameById((int)$value);
			case "company" :
				return Company::getNameById((int)$value);
			default :
				return $value;
		}
	}
}
