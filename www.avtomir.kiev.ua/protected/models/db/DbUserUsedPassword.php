<?php

/**
 * This is the model class for table "user_usedpasswords".
 *
 * The followings are the available columns in table 'user_usedpasswords':
 * @property integer $up_id
 * @property integer $up_user_id
 * @property string $up_password
 * @property string $up_seton
 *
 * The followings are the available model relations:
 * @property Users $upUser
 */
class DbUserUsedpassword extends CActiveRecord
{
	public function tableName()
	{
		return 'user_usedpassword';
	}

	public function rules()
	{
		// used only internally
		return array(
		);
	}

	public function relations()
	{
		return array(
			'upUser' => array(self::BELONGS_TO, 'User', 'up_user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'up_id' => 'id',
			'up_user_id' => 'User ID',
			'up_password' => 'Password',
			'up_seton' => 'Date used',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('up_id',$this->up_id);
		$criteria->compare('up_user_id',$this->up_user_id);
		$criteria->compare('up_password',$this->up_password,true);
		$criteria->compare('up_seton',$this->up_seton,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UserUsedpasswords the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function verifyPassword($password)
	{
		return $this->up_password !== null && password_verify($password, $this->up_password);
	}
}
