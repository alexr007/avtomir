<?php

/**
 * Created by PhpStorm.
 * User: alexr
 * Date: 07.03.2017
 * Time: 12:35
 */
class InvoiceLine implements IInvoiceLine
{
    private $pn;
    private $qty;

    public function __construct(InvPartNumber $pn, $qty) {
        $this->pn = $pn;
        $this->qty = (new NormalizedQty($qty))->get();
    }

    public function pn() {
        return $this->pn;
    }

    public function qty() {
        return $this->qty;
    }

    public function toString() {
        return "V:".$this->pn->vendor().
            " N:".$this->pn->number().
            " Q:".$this->qty();
    }

    public function incQty($val) {
        $this->qty += $val;
    }

    public function decQty($val) {
        $this->qty -= $val;
    }

}