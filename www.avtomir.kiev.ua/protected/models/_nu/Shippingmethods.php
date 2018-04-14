<?php

/**
 * This is the model class for table "shippingmethods".
 *
 * The followings are the available columns in table 'shippingmethods':
 * @property integer $sm_id
 * @property string $sm_name
 * @property string $sm_comment
 * @property string $sm_enable
 */
class Shippingmethods extends LActiveRecord
{
	public static $list_key_field='sm_id';
	public static $list_name_field='sm_name';
	public static $list_sort_field='sm_name';
	
	public function tableName()
	{
		return 'shipping_methods';
	}

	public function rules()
	{
		return array(
			array('sm_name, sm_comment, sm_enable', 'safe'),
			array('sm_id, sm_name, sm_comment, sm_enable', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'tariffs' => array(self::HAS_MANY, 'Tariffs', 'tf_method'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'sm_id' => 'id',
			'sm_name' => 'Shipping Method',
			'sm_comment' => 'Comment',
			'sm_enable' => 'Enable',
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('sm_id',$this->sm_id);
		$criteria->compare('sm_name',$this->sm_name,true);
		$criteria->compare('sm_comment',$this->sm_comment,true);
		$criteria->compare('sm_enable',$this->sm_comment);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function scopes()
    {
        return [
            'enabled'=>[
                'condition'=>"sm_enable=1",
            ],
        ];
    }
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/// id
	public function getId()
	{
		return $this->sm_id;
	}
	
	public function setId($value = null)
	{
		$this->sm_id = $value;
		return $this;
	}
	
	/// name
	public function getName()
	{
		return $this->sm_name == null ? '' : $this->sm_name;
	}
	
	public function setName($value = null)
	{
		$this->sm_name = $value;
		return $this;
	}
	
	/// comment
	public function getComment()
	{
		return $this->sm_comment == null ? '' : $this->sm_comment;
	}
	
	public function setComment($value = null)
	{
		$this->sm_comment = $value;
		return $this;
	}
	
	/// enable
	public function getEnable()
	{
		return $this->sm_enable;
	}
	
	public function setEnable($value = null)
	{
		$this->sm_enable = $value;
		return $this;
	}
}
