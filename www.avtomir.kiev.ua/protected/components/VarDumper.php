<?php

class VarDumper extends CVarDumper {
    /**
     * Displays a variable.
     * This method achieves the similar functionality as var_dump and print_r
     * but is more robust when handling complex objects such as Yii controllers.
     * @param mixed variable to be dumped
     * @param integer maximum depth that the dumper should go into the variable.
     * @param boolean whether the result should be syntax-highlighted
     */
    public static function dump($var,$depth=10,$highlight=true){
        echo self::dumpAsString($var,$depth,$highlight);
    }
	
    public static function dump2($var,$depth=10,$highlight=true){
		echo self::dumpAsString($var[0],$depth,$highlight);
        if (isset($var[1])) echo $var[1];
    }
	
    public static function dump3($var,$depth=10,$highlight=true){
        echo $var[0];
		echo self::dumpAsString($var[1],$depth,$highlight);
        if (isset($var[2])) echo $var[2];
    }
}