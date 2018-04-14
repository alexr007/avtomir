<?php

class DbBalanceTotalStatistics extends CActiveRecord
{
    public function tableName()
    {
        return 'balance_total_statistics';
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function getBalanceCurrentS()
    {
        return $this->balance ? (new NumberFormatted($this->balance))->value() : null;
    }

    public function getAmountReadyS()
    {
        return $this->ready ? (new NumberFormatted($this->ready))->value() : null;
    }

    public function getAmountWorkS()
    {
        return $this->work ? (new NumberFormatted($this->work))->value() : null;
    }

    public function getAmountNewS()
    {
        return $this->new ? (new NumberFormatted($this->new))->value() : null;
    }

    public function getBalanceTotalS()
    {
        return $this->total ? (new NumberFormatted($this->total))->value() : null;
    }
}