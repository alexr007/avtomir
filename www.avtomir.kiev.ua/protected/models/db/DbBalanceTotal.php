<?php

class DbBalanceTotal extends CActiveRecord
{
    public function tableName()
    {
        return 'balance_total';
    }

    public function getTableSchema()
    {
        // вот так делается pk для View
        // primaryKey for view
        $table = parent::getTableSchema();
        $table->primaryKey='agent';
        return $table;
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function rules()
    {
        return array(
            array('name', 'safe'),
            array('name', 'safe', 'on'=>'search'),
        );
    }

    public function getAgentId()
    {
        return $this->agent;
    }

    public function getAgentName()
    {
        return $this->name;
    }

    public function getBalanceCurrent()
    {
        return $this->balance;
    }

    public function getBalanceCurrentS()
    {
        return $this->balance ? (new NumberFormatted($this->balance))->value() : null;
    }

    public function getAmountReady()
    {
        return $this->ready;
    }

    public function getAmountReadyS()
    {
        return $this->ready ? (new NumberFormatted($this->ready))->value() : null;
    }

    public function getAmountWork()
    {
        return $this->work;
    }

    public function getAmountWorkS()
    {
        return $this->work ? (new NumberFormatted($this->work))->value() : null;
    }

    public function getAmountNew()
    {
        return $this->new;
    }

    public function getAmountNewS()
    {
        return $this->new ? (new NumberFormatted($this->new))->value() : null;
    }

    public function getBalanceTotal()
    {
        return $this->total;
    }

    public function getBalanceTotalS()
    {
        return $this->total ? (new NumberFormatted($this->total))->value() : null;
    }

    public function search()
    {
        $criteria=new CDbCriteria;
        $criteria->compare('upper(name)',mb_strtoupper($this->name), true);
        return new CActiveDataProvider($this, [
            'criteria'=>$criteria,
        ]);
    }
}