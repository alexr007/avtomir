<?php

/**
 * Created by PhpStorm.
 * User: alexr
 * Date: 02.02.2017
 * Time: 13:54
 *
 * эта хрень высчитывает Общий статус заказа на основании статусов его позиций
 *
 * ее надо вызывать всегда, когда поменяли статус хоть одного Order_Item.STATUS
 * ее вызываем сознательно вручную, после изменения всего DataSet,
 * чтобы не было лишнего обносления данных
 *
 */
class CalculateNewOrderStatus
{
    private $oi_order;

    public function __construct($orderid)
    {
        $this->oi_order=$orderid;
        $this->calcNewOrderStatus();
    }

    private function calcNewOrderStatus()
    {
        $command = Yii::app()->db->createCommand();
        $rows = $command
            ->select("oi_status")
            ->from("order_item")
            ->where("oi_order=:id", ["id"=>$this->oi_order])
            ->group("oi_status")
            ->queryAll();
        $newStatus = $this->calcOrderStatusFromArray($rows);
        $order = DbOrder::model()->findByPk($this->oi_order);
        if($newStatus != $order->o_status) {
            $order->o_status=$newStatus;
            $order->save();
        }
    }

    private function calcOrderStatusFromArray($source) {
        $new = [DbOrderItemStatus::OIS_NEW];
        $finished = [DbOrderItemStatus::OIS_FINISHED, DbOrderItemStatus::OIS_CANCELLED];
        $ret = DbOrderStatus::OS_INPROCESS;
        if (count($source)==1) {
            if ( in_array($source[0]['oi_status'], $new)) {
                $ret = DbOrderStatus::OS_CREATED;
            } else
                if ( in_array($source[0]['oi_status'], $finished)) {
                    $ret = DbOrderStatus::OS_DONE;
                }
        }
        else {
            if ((count($source)==2)
                &&(in_array($source[0]['oi_status'], $finished))
                &&(in_array($source[1]['oi_status'], $finished)))
            {
                $ret = DbOrderStatus::OS_DONE;
            }
        }
        return $ret;
    }

}