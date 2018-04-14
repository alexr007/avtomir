<?php

/**
 * Created by PhpStorm.
 * User: alexr
 * Date: 14.03.2017
 * Time: 11:54
 */
class DbLine implements IInvoiceLine
{
    private $key;
    private $pn;
    private $qty;

    /**
     * DbLine constructor.
     * @param $key
     * @param $pn
     * @param $qty
     */
    public function __construct($key, $pn, $qty)
    {
        $this->key = $key;
        $this->pn = $pn;
        $this->qty = $qty;
    }

    /**
     * @return mixed
     */
    public function key()
    {
        return $this->key;
    }

    /**
     * @return mixed
     */
    public function pn()
    {
        return $this->pn;
    }

    /**
     * @return mixed
     */
    public function qty()
    {
        return $this->qty;
    }

    public function equals(DbLine $ln) {
        return
            ($this->key() === $ln->key()) &&
            ($this->pn() === $ln->pn()) &&
            ($this->qty() === $ln->qty());
    }

    public function toString() {
        return
            "ID:".$this->key.
            " V:".$this->pn->vendor().
            " N:".$this->pn->number().
            " Q:".$this->qty();
    }
}