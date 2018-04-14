<?php

/**
 * This is the model class for table "user_profile_fields".
 *
 * The followings are the available columns in table 'user_profile_fields':
 * @property integer $upf_id
 * @property integer $upf_type
 * @property string $upf_name
 * @property string $upf_description
 * @property string $upf_default
 * @property integer $upf_enable
 * @property integer $upf_order
 *
 * The followings are the available model relations:
 * @property UserProfile[] $userProfiles
 */
class UserProfileFields extends LActiveRecord
{
	public static $list_key_field='upf_id';
	public static $list_name_field='upf_name';
	public static $list_sort_field='upf_order';
	
	
	public function tableName()
	{
		return 'user_profile_fields';
	}

	public function rules()
	{
		return array(
			array('upf_type, upf_enable, upf_order', 'numerical', 'integerOnly'=>true),
			array('upf_name, upf_description, upf_default, upf_show', 'safe'),
			array('upf_id, upf_type, upf_name, upf_description, upf_default, upf_enable, upf_order, upf_show', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return [
			'userProfiles' => [self::HAS_MANY, 'UserProfile', 'up_field'],
		];
	}

	public function attributeLabels()
	{
		return [
			'upf_id' => 'Column ID',
			'upf_type' => 'Column Type',
			'upf_name' => 'Column Name',
			'upf_description' => 'Column Description',
			'upf_default' => 'Default Value',
			'upf_enable' => 'Enable Field',
			'upf_order' => 'Sort Order',
			'upf_show' => 'Show @user',
		];
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('upf_id',$this->upf_id);
		$criteria->compare('upf_type',$this->upf_type);
		$criteria->compare('upf_name',$this->upf_name,true);
		$criteria->compare('upf_description',$this->upf_description,true);
		$criteria->compare('upf_default',$this->upf_default,true);
		$criteria->compare('upf_enable',$this->upf_enable);
		$criteria->compare('upf_order',$this->upf_order);
		$criteria->compare('upf_show',$this->upf_show);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>[ 'defaultOrder'=>'upf_order ASC',],
			'pagination'=>['pageSize'=>20],
		));
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public static function getIdByName($name = null)
	{
		if ($name == null) return 0;
		$f = UserProfileFields::model()->findByAttributes(['upf_name'=>mb_strtolower($name)]);
		if ($f == null) return 0;
			else return $f->upf_id;
	}
	
	public static function getTypeById($id = null)
	{
		if ($id == null) return 0;
		$f = UserProfileFields::model()->findByAttributes(['upf_id'=>$id]);
		if ($f == null) return 0;
			else return $f->upf_type;
	}
	
    public function scopes()
    {
		return [
            'enabled'=>[
				'condition'=>"upf_enable=1"
				],
        ];
    }
	
    public function createNewFieldForAllUsers()
    {
		$cmd=self::model()->dbConnection->createCommand("insert into user_profile(up_user, up_field, up_value) select u_id, :id, :value from users");
		$cmd->bindValues([	':id'=>(int)$this->upf_id,
							':value'=>$this->upf_default]);
		$cmd->execute();
		
		return true;
    }
	
    public function deleteFieldFromAllUsers()
    {
		$cmd=self::model()->dbConnection->createCommand("delete from user_profile where up_field=:id");
		$cmd->bindValues([':id'=>(int)$this->upf_id]);
		$cmd->execute();
		
		return true;
    }
	
	protected function beforeSave()
    {
		if ($this->upf_show==null) $this->tr_total=1; // видна у пользователя
        return parent::beforeSave();
    }
	
	protected function afterSave()
    {
		parent::afterSave();
		
		if ($this->isNewRecord)
			// здесь добавляем поле всем пользователям
			if (!$this->createNewFieldForAllUsers()) return false;
		
		return true;
    }
	
	protected function beforeDelete()
    {
		if (!$this->deleteFieldFromAllUsers()) return false;
		
		parent::beforeDelete();
		
		return true;
    }
}
