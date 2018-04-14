<?php

/**
 * Created by PhpStorm.
 * User: alexr
 * Date: 08.02.2017
 * Time: 23:06
 */
class DbPriceItem {
    private $vendor;
    private $number;
    private $name;
    private $price;
    private $weight;

    public function __construct($vendor, $number, $name, $price, $weight) {
        $this->vendor = $vendor;
        $this->number = $number;
        $this->name = $name;
        $this->price = $price;
        $this->weight = $weight;
    }

    public function vendor()
    {
        return $this->vendor;
    }

    public function number()
    {
        return $this->number;
    }

    public function name()
    {
        return $this->name;
    }

    public function price()
    {
        return $this->price;
    }

    public function weight()
    {
        return $this->weight;
    }

    public function saveToDb() {
        Yii::app()->db->createCommand()
            ->insert("price",[
                "pr_vendor"=>$this->vendor(),
                "pr_number"=>$this->number(),
                "pr_name"=>$this->name(),
                "pr_price"=>$this->price(),
                "pr_weight"=>$this->weight()
            ]);
        return;




        $dbPrice = new DbPrice();
        $dbPrice->pr_vendor = $this->vendor();
        $dbPrice->pr_number = $this->number();
        $dbPrice->pr_name = $this->name();
        $dbPrice->pr_price = $this->price();
        $dbPrice->pr_weight = $this->weight();
        $dbPrice->pr_date = new DbCurrentTimestamp();
        $dbPrice->save();
    }
}