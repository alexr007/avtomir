<?php

/**
 * Created by PhpStorm.
 * User: alexr
 * Date: 14.02.2017
 * Time: 13:23
 */
class ExchangeRate {
    private $from;
    private $to;
    const DELIM="_";

    public function __construct(Currency $from, Currency $to) {
        $this->from = $from;
        $this->to = $to;
    }

    private function fieldName() {
        return $this->from->get().ExchangeRate::DELIM.$this->to->get();
    }

    public function rate() {
        return
            (new Parameter('system', $this->fieldName()))->value()/1000;
    }
}