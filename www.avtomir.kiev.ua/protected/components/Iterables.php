<?php

/**
 * Created by PhpStorm.
 * User: alexr
 * Date: 13.03.2017
 * Time: 22:39
 */
class Iterables
{
    public static function each($source, $func) {
        foreach ($source as $item) {
            $func($item);
        }
    }
}