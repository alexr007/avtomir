<?php

/**
 * Created by PhpStorm.
 * User: alexr
 * Date: 07.03.2017
 * Time: 13:53
 */
class NormalizedVendor {

    const MIN_LENGTH = 2;
    const MAX_LENGTH = 32;
    const RULES = [
        ['search'=>'/[\W]/', // разрешаем A-Z, 0-9, _
            'replace'=>''], // оставляем цифры, буквы, и _
        ['search'=>'/[_]/',
            'replace'=>'']  // удаляем подчеркивание
    ];

    private $origin;

    public function __construct($number)
    {
        $this->origin = $number;
    }

    public function get() {
        $num = trim(mb_strtoupper($this->origin));
        foreach (self::RULES as $rule) {
            $num = preg_replace($rule['search'], $rule['replace'], $num);
        }
        $len = mb_strlen($num);
        if (($len < self::MIN_LENGTH) || ($len > self::MAX_LENGTH))
            throw new NormalizedPartNumberException($num);
        return $num;
    }

}