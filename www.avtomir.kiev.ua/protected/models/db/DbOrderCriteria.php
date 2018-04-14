<?php

class DbOrderCriteria extends AbstractAddCriteria {
	
	protected function byEntity($object)
	{
		$criteria=new CDbCriteria();
		
		$criteria->compare('o_id',$object->o_id);
		$criteria->compare('o_number',$object->o_number,true);
		$criteria->compare('o_cagent',$object->o_cagent);
		$criteria->compare('o_status',$object->o_status);
		$criteria->compare('o_date_in',$object->o_date_in,true);
		$criteria->compare('o_date_process',$object->o_date_process,true);
		$criteria->compare('o_date_close',$object->o_date_close,true);

		$criteria->mergeWith($this->criteria);
		return $criteria;
	}
	
	public function orderByDateDesc()
	{
		$criteria=new CDbCriteria();
		$criteria->order = 'o_date_in DESC';
		
		$criteria->mergeWith($this->criteria);
		return $criteria;
	}

	public function byCagent(IRuntimeUser $user)
	{
		$criteria=new CDbCriteria();
		$criteria->compare('o_cagent', (int)$user->cagentId());
		
		$criteria->mergeWith($this->criteria);
		return $criteria;
	}

    public function onlyNewOrders()
    {
        $criteria=new CDbCriteria();
        $criteria->compare('o_status', DbOrderStatus::OS_CREATED);

        $criteria->mergeWith($this->criteria);
        return $criteria;
    }

}
