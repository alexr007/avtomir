<?php

/**
 * Created by PhpStorm.
 * User: alexr
 * Date: 14.03.2017
 * Time: 15:52
 */
class OrderUpdateInvNumber
{
    private $origin; //JList

    /**
     * OrderUpdateInvNumber constructor.
     * @param $origin
     */
    public function __construct($origin)
    {
        $this->origin = $origin;
    }

    public function updateInvoiceNumber($number) {
        $keys = new CList();
        //$orders = new CUniqueNonEmplyList();
        foreach ($this->origin as $line) {
            $keys->add($line->key());
            //$orders->add($line->orderId()); //todo !!!!! $line->orderId()
        }
        if ($keys->count) {
            $keys=implode(',',$keys->toArray());
            $NEW_STATUS=DbOrderItemStatus::OIS_DELIVERY;
            Yii::app()->db->createCommand("UPDATE order_item set oi_status=$NEW_STATUS, oi_invoice=$number WHERE oi_id in ($keys)")->execute();
            /*
             * здесь обновлять статус заказа не надо,
             * т.к. ORDERED и DELIVERY всодится в одному статусу заказа
             * DbOrderStatus::OS_INPROCESS
             *
             * foreach ($orders as $order) {
             *     new CalculateNewOrderStatus($order);
             * }
             *
             */
        }
    }
}