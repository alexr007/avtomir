<?php

/**
 * Created by PhpStorm.
 * User: alexr
 * Date: 14.02.2017
 * Time: 13:27
 */
class ExchangeEURUSD {
    private $exchange;

    public function __construct()
    {
        $this->exchange = new ExchangeRate(
            new Currency('EUR'),
            new Currency('USD')
        );
    }

    private function rate() {
        return $this->exchange->rate();
    }

    public function value($origin) {
        return $origin * $this->rate();
    }

}