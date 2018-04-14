<?php

/**
 * Created by PhpStorm.
 * User: alexr
 * Date: 08.02.2017
 * Time: 22:51
 */
class FileTxt extends File {

    public function rules()
    {
        return [
            ['image', 'file', 'types'=>'txt', 'allowEmpty'=>false, 'maxSize' => 50000000],
        ];
    }

    public function getType()
    {
        return self::T_TXT;
    }

    public function getFolderAlias()
    {
        return 'txt.price';
    }

}