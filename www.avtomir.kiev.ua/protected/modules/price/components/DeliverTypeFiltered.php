<?php

/**
 * Created by PhpStorm.
 * User: alexr
 * Date: 14.02.2017
 * Time: 16:52
 */
class DeliverTypeFiltered {
    public $allowed = [
        ['dealer'=>1, 'allowed'=>[1,2]], // AMT
        ['dealer'=>2, 'allowed'=>[1]], // Vivat
        ['dealer'=>4, 'allowed'=>[1]], //Germany
    ];

    public function getAllowedByDealer($dealer) {
        $ret = [];
        foreach ($this->allowed as $allowed_item) {
            if ($allowed_item['dealer'] == $dealer) {
                $ret=$allowed_item['allowed'];
                break;
            }
        }
        return $ret;
    }
}