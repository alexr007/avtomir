<?php

/**
 * Created by PhpStorm.
 * User: alexr
 * Date: 14.02.2017
 * Time: 13:25
 */
class Currency {
    private $origin;

    public function __construct($origin) {
        $this->origin = $origin;
    }

    public function get() {
        return $this->origin;
    }

}