<?php

class DFileHelper
{
    public static function getRandomFileName($path='', $extension='')
    {
        $extension = $extension ? '.'.$extension : '';
        $path = $path ? $path . '/' : '';
 
        do {
            $name = md5(microtime() . rand(0, 9999));
			//$name = md5(uniqid(rand(),true)); 

            $file = $path . $name . $extension;
        } while (file_exists($file));
 
        return $name;
    }
}