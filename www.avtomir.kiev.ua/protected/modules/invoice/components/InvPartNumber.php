<?php

/**
 * Created by PhpStorm.
 * User: alexr
 * Date: 09.03.2017
 * Time: 22:39
 */
class InvPartNumber
{
    private $vendor;
    private $number;

    public function __construct($vendor, $number)
    {
        $this->vendor = (new NormalizedVendor($vendor))->get();
        $this->number = (new NormalizedPartNumber($number))->get();
    }

    public function vendor()
    {
        return $this->vendor;
    }

    public function number()
    {
        return $this->number;
    }

    public function equals(InvPartNumber $pn) {
        return
            ($this->vendor() === $pn->vendor()) &&
            ($this->number() === $pn->number());
    }

    public function toString() {
        return "V:".$this->vendor().
            " N:".$this->number();
    }

}