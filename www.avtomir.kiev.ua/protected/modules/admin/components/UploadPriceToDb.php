<?php

/**
 * Created by PhpStorm.
 * User: alexr
 * Date: 08.02.2017
 * Time: 23:03
 */
class UploadPriceToDb
{
    private $file;

    public function __construct($file) {
        $this->file = $file;
    }

    private function stripQuotes($line) {
        $line2 = str_replace(",",".",$line);
        //return $line2;`
        return substr($line2,1,strlen($line2)-2);
    }

    public function upload() {
        set_time_limit(0);
        ignore_user_abort(true);
        ini_set('max_execution_time', 0);

        $handle = fopen($this->file, "r");
        fgets($handle);


        $transaction = Yii::app()->db->beginTransaction();
        $count = 0;

        while ($line = trim(fgets($handle))) {
            $items = explode(";", $line);
            $pi = new DbPriceItem(1,
                $this->stripQuotes($items[0]),
                $this->stripQuotes($items[1]),
                $this->stripQuotes($items[2]),
                $this->stripQuotes($items[6])
            );
            $pi->saveToDb();
            $count++;
            if ($count % 10000 ==0) {
                $transaction->commit();
                $transaction = Yii::app()->db->beginTransaction();
            }
        }

        $transaction->commit();
    }
}