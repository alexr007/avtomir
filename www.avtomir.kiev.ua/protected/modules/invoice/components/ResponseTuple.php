<?php

/**
 * Created by PhpStorm.
 * User: alexr
 * Date: 14.03.2017
 * Time: 14:54
 */
class ResponseTuple {
    private $order;
    private $invoice;

    /**
     * ResponseTuple constructor.
     * @param $order
     * @param $invoice
     */
    public function __construct($order, $invoice)
    {
        $this->order = $order;
        $this->invoice = $invoice;
    }

    /**
     * @return mixed
     */
    public function order()
    {
        return $this->order;
    }

    /**
     * @return mixed
     */
    public function invoice()
    {
        return $this->invoice;
    }


}