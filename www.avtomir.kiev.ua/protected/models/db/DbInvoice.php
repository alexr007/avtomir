<?php

/**
 * This is the model class for table "invoice".
 *
 * The followings are the available columns in table 'invoice':
 * @property integer $in_id
 * @property integer $in_dealer
 * @property string $in_number
 * @property string $in_comment
 * @property string $in_date
 *
 * The followings are the available model relations:
 * @property Dealer $inDealer
 */
class DbInvoice extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'invoice';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('in_dealer', 'numerical', 'integerOnly'=>true),
			array('in_number, in_comment, in_date', 'safe'),
            array('in_dealer, in_number, in_comment, in_date', 'safe'),
			array('in_id, in_dealer, in_number, in_comment, in_date', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'inDealer' => array(self::BELONGS_TO, 'DbDealer', 'in_dealer'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'in_id' => 'In',
			'in_dealer' => 'In Dealer',
			'in_number' => 'In Number',
			'in_comment' => 'In Comment',
			'in_date' => 'In Date',
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

		$criteria->compare('in_id',$this->in_id);
		$criteria->compare('in_dealer',$this->in_dealer);
		$criteria->compare('in_number',$this->in_number,true);
		$criteria->compare('in_comment',$this->in_comment,true);
		$criteria->compare('in_date',$this->in_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DbInvoice the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function beforeSave()
    {
        if (parent::beforeSave()) {
            if ($this->in_date == null) {
                $this->in_date = new DbCurrentTimestamp();
            }
            return true;
        }
        return false;
    }

    public function getNumber() {
	    return $this->in_number;
    }

}
