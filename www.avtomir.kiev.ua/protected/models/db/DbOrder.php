<?php

/**
 * This is the model class for table "orders".
 *
 * The followings are the available columns in table 'orders':
 * @property integer $o_id
 * @property string $o_number
 * @property integer $o_user
 * @property integer $o_status
 * @property string $o_date_in
 * @property string $o_date_process
 * @property string $o_date_close
 */
class DbOrder extends CActiveRecord
{
	public function tableName()
	{
		return 'orders';
	}

	public function rules()
	{
		return [
			['o_id, o_number, o_cagent, o_status, o_date_in, o_date_process, o_date_close, o_comment_user, o_comment_oper', 'safe'],
			['o_id, o_number, o_cagent, o_status, o_date_in, o_date_process, o_date_close, o_comment_user, o_comment_oper', 'safe', 'on'=>'search'],
		];
	}

	public function relations()
	{
		return [
			'oCagent' => [self::BELONGS_TO, 'DbCagent', 'o_cagent'],
			'oStatus' => [self::BELONGS_TO, 'DbOrderStatus', 'o_status'],
			'oStatistic' => [self::BELONGS_TO, 'DbOrderStatistics', 'o_id'],
            'oItems' => [self::HAS_MANY, 'DbOrderItem', 'o_id'],
		];
	}

	public function attributeLabels()
	{
		return array(
			'o_id' => 'id',
			'o_number' => 'Number',
			'o_cagent' => 'Cagent',
			'o_status' => 'Status',
			'o_date_in' => 'Date In',
			'o_date_process' => 'Date Processed',
			'o_date_close' => 'Date Closed',
			'o_comment_user' => 'User comment',
			'o_comment_oper' => 'Operator comment',
		);
	}
	
	public function search($addCriteria = null)
	{
		$criteria=(new DbOrderCriteria($this))->criteria();
		
		if ($addCriteria) {
            if (is_array($addCriteria)) {
                foreach ($addCriteria as $addCriteriaItem) {
                    $criteria->mergeWith($addCriteriaItem);
                }
            }
            else {
                $criteria->mergeWith($addCriteria);
            }
        }

		return new CActiveDataProvider($this, [
			'criteria'=>$criteria,
            'pagination'=>['pageSize'=>22],
		]);
	}
	
	public function getId()
	{
		return $this->o_id;
	}
	
	public function getCagentS()
	{
		return $this->o_cagent > 0 ? $this->oCagent->name : "";
	}
	
	public function getStatusS()
	{
		return $this->oStatus->os_name;
	}
	
	public function getDateInS()
	{
		return (new DateFormatted($this->o_date_in, "d.m.Y H:m"))->date();
	}
	
	public function getDateProcessS()
	{
		return (new DateFormatted($this->o_date_process))->date();
	}
	
	public function getDateCloseS()
	{
		return (new DateFormatted($this->o_date_close))->date();
	}
	
	
	public function getTotalUniqueNumbers()
	{
		return ($this->oStatistic == null) ? 0 :
			$this->oStatistic->getTotalUniqueNumbers();
	}
	
	public function getTotalItems()
	{
		return ($this->oStatistic == null) ? 0 :
			$this->oStatistic->getTotalItems();
	}
	
	public function getTotalMoney()
	{
		return ($this->oStatistic == null) ? 0 :
			$this->oStatistic->getTotalMoney();
	}
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
}
