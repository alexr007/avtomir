<?php

/**
 * This is the model class for table "money".
 *
 * The followings are the available columns in table 'money':
 * @property integer $mo_id
 * @property string $mo_date
 * @property integer $mo_cagent
 * @property string $mo_amount
 * @property string $mo_comment
 *
 * The followings are the available model relations:
 * @property Cagents $moCagent
 */
class DbMoney extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'money';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('mo_cagent', 'numerical', 'integerOnly'=>true),
			array('mo_date, mo_amount, mo_comment', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('mo_id, mo_date, mo_cagent, mo_amount, mo_comment', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'moCagent' => array(self::BELONGS_TO, 'DbCagent', 'mo_cagent'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'mo_id' => 'id',
			'mo_date' => 'Date',
			'mo_cagent' => 'Contragent',
			'mo_amount' => 'Amount (USD)',
			'mo_comment' => 'Comment',
		);
	}

    public function beforeSave()
    {
        if (parent::beforeSave()) {
            // деньги храним в центах
            $this->mo_amount = $this->mo_amount * 100;
            $this->mo_date = new DbCurrentTimestamp();
            return true;
        }
        return false;
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

		$criteria->compare('mo_id',$this->mo_id);
		$criteria->compare('mo_date',$this->mo_date,true);
		$criteria->compare('mo_cagent',$this->mo_cagent);
		if ($this->mo_amount) {
            // special handling DB cents store
		    $value = $this->mo_amount;
		    if(preg_match('/^(?:\s*(<>|<=|>=|<|>|=))?(.*)$/',$value,$matches)) {
                $value=$matches[2];
                $op=$matches[1];
            }
            else {
                $op='';
            }
            $this->mo_amount = $op.($value*100);

            $criteria->compare('mo_amount',$this->mo_amount);
        }
		$criteria->compare('mo_comment',$this->mo_comment,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DbMoney the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function getAmountUSD() {
        if ($this->mo_amount) {
            // special handling DB cents store
            $value = $this->mo_amount;
            if(preg_match('/^(?:\s*(<>|<=|>=|<|>|=))?(.*)$/',$value,$matches)) {
                $value=$matches[2];
                $op=$matches[1];
            }
            else {
                $op='';
            }
            return $op.(new NumberFormatted($value/100))->value();
        }
    }

    public function getDate() {
        return (new DateFormatted($this->mo_date))->value();
    }

    public function getCagentS() {
        return $this->mo_cagent > 0 ? $this->moCagent->name : "";
    }

}
