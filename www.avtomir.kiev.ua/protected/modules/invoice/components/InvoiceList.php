<?php

/**
 * Created by PhpStorm.
 * User: alexr
 * Date: 09.03.2017
 * Time: 23:34
 */
class InvoiceList implements IteratorAggregate
{
    private $list;

    public function __construct() {
        $this->list = new JList();
    }

    public function getIterator() {
        return $this->list->getIterator();
    }

    public function add(IInvoiceLine $line) {
        if (($index = $this->indexOf($line->pn())) === false) {
            $this->list->add($line);
        }
        else {
            // это бизнес логика.
            // если уже существует такой элемент - то увеличиваем его количество
            $this->list->itemAt($index)->incQty($line->qty());
        }
    }

    // ищет InvPartNumber
    // в коллекции InvoiceLine
    private function indexOf(InvPartNumber $item) {
        $ret = false;
        foreach ($this->list as $k=>$listItem) {
            if ($listItem->pn()->equals($item)) {
                $ret = $k;
                break;
            }
        }
        return $ret;
    }

    public function remove(InvPartNumber $item) {
        $index = $this->indexOf($item);
        if ($index === false) {
            return false;
        }
        else {
            $this->list->removeAt($index);
            return true;
        }
    }

    public function count() {
        return $this->list->count();
    }
    /*
    public function contains(InvPartNumber $item) {
        return $this->indexOf($item) !== false;
    }

    public function toString() {
        return $this->list->toString();
    }

    public function totalQtyCount() {
        $cnt = 0;
        foreach ($this->list as $item) {
            $cnt += $item->qty;
        }
        return $cnt;
    }

    */
}