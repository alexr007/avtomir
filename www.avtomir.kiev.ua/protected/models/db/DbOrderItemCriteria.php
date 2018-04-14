<?php

class DbOrderItemCriteria extends AbstractAddCriteria {
	
	protected function byEntity($object)
	{
		$criteria=new CDbCriteria();
		
		$criteria->compare('oi_id',$object->oi_id);
		$criteria->compare('oi_order',$object->oi_order);
		$criteria->compare('oi_status',$object->oi_status);
		$criteria->compare('oi_ship_method',$object->oi_ship_method);
		$criteria->compare('oi_dealer',$object->oi_dealer);
		$criteria->compare('upper(oi_vendor)',mb_strtoupper($object->oi_vendor),true);
		$criteria->compare('upper(oi_number)',mb_strtoupper($object->oi_number),true);
		$criteria->compare('oi_desc_en',$object->oi_desc_en,true);
		$criteria->compare('oi_desc_ru',$object->oi_desc_ru,true);
		$criteria->compare('oi_depot',$object->oi_depot,true);
		$criteria->compare('oi_qty',$object->oi_qty);
		$criteria->compare('oi_price',$object->oi_price,true);
		$criteria->compare('oi_weight',$object->oi_weight,true);
		$criteria->compare('oi_volume',$object->oi_volume,true);
		$criteria->compare('oi_comment_user',$object->oi_comment_user,true);
		$criteria->compare('oi_comment_oper',$object->oi_comment_oper,true);
		$criteria->compare('oi_date_process',$object->oi_date_process,true);
		$criteria->compare('oi_date_dealer_ship',$object->oi_date_dealer_ship,true);
		$criteria->compare('oi_date_received',$object->oi_date_received,true);
		$criteria->compare('oi_date_shipped',$object->oi_date_shipped,true);
        $criteria->compare('oi_invoice',$object->oi_invoice);

		$criteria->mergeWith($this->criteria);
		return $criteria;
	}
	
	public function byId($id)
	{
		$criteria=new CDbCriteria();
		$criteria->compare('oi_order', (int)$id);
		$criteria->mergeWith($this->criteria);
		return $criteria;
	}

    public function byMethod($id)
    {
        $criteria=new CDbCriteria();
        $criteria->compare('oi_ship_method', (int)$id);
        $criteria->mergeWith($this->criteria);
        return $criteria;
    }

    public function byDealer($id)
    {
        $criteria=new CDbCriteria();
        $criteria->compare('oi_dealer', (int)$id);
        $criteria->mergeWith($this->criteria);
        return $criteria;
    }

    public function byCagent($user)
	{
		$criteria=new CDbCriteria();
		$criteria->join ='JOIN orders ON (o_id=oi_order)';
		$criteria->compare('o_cagent', $user->cagentId());
		$criteria->mergeWith($this->criteria);
		return $criteria;
	}

    public function byItemStatus($status = [])
    {
        $criteria=new CDbCriteria();
        if (is_array($status)) {
            $criteria->addInCondition('oi_status', $status);
        }
        $criteria->mergeWith($this->criteria);
        return $criteria;
    }

    // фильтр по статусу Order НЕ orderItem !
	public function byType($type)
    {
        $criteria=new CDbCriteria();
        $criteria->join ='JOIN orders ON (o_id=oi_order)';
        $criteria->compare('orders.o_status', $type);
        $criteria->mergeWith($this->criteria);
        return $criteria;
    }

    public function orderByDate()
    {
        $criteria=new CDbCriteria();
        $criteria->join ='JOIN orders ON (o_id=oi_order)';
        $criteria->order='orders.o_date_in ASC';
        $criteria->mergeWith($this->criteria);
        return $criteria;
    }
}
