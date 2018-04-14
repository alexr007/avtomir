<?php

/**
 * Created by PhpStorm.
 * User: alexr
 * Date: 07.03.2017
 * Time: 13:55
 */
class NormalizedQty
{
    const MIN_LENGTH = 1;
    const MAX_LENGTH = 8;
    const RULES = [
        ['search'=>'/[^0-9]/', // разрешаем 0-9, _
            'replace'=>''],
    ];

    private $origin;

    public function __construct($number)
    {
        $this->origin = $number;
    }

    public function get() {
        $num = trim($this->origin);
        foreach (self::RULES as $rule) {
            $num = preg_replace($rule['search'], $rule['replace'], $num);
        }
        $len = mb_strlen($num);
        if (($len < self::MIN_LENGTH) || ($len > self::MAX_LENGTH)) {
            $num=0;
        }
        return (int)$num;
    }

}