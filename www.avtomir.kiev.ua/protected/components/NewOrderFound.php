<?php

class NewOrderFound {
	
	public function found()
	{
        return Yii::app()->db->createCommand()
            ->select("COUNT(*)")
            ->from("orders")
            ->where("o_status=:id", ["id"=>DbOrderStatus::OS_CREATED])
            ->queryScalar()
            >0;
	}

	public function moduleLink() {
	    return '/price/order/new';
    }

    public function htmlOptions() {
        return ['class'=>'new-orders'];
    }

}
