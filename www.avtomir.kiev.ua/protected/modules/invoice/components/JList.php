<?php

/**
 * Created by PhpStorm.
 * User: alexr
 * Date: 09.03.2017
 * Time: 23:03
 *
 * поиск элемента по массиву с помощи
 * функции equals элемента массива
 *
 */
class JList implements IteratorAggregate{
    private $list;

    public function __construct() {
        $this->list = new CList();
    }

    public function add($item) {
        $this->list->add($item);
    }

    private function indexOf($item) {
        $ret = false;
        foreach ($this->list as $k=>$listItem) {
            if ($listItem->equals($item)) {
                $ret = $k;
                break;
            }
        }
        return $ret;
    }

    public function remove($item) {
        $ret = false;
        if (($index = $this->indexOf($item)) !== false) {
            $this->list->removeAt($index);
            $ret = true;
        }
        return $ret;
    }

    public function contains($item) {
        return $this->indexOf($item) !== false;
    }

    public function toString() {
        $s="";
        $del="";
        foreach ($this->list as $listItem) {
            $s .= $del.$listItem->toString();
            $del ="\n";
        }
        return $s;
    }

    public function getIterator() {
        return $this->list->getIterator();
    }

    public function removeAt($index) {
        $this->list->removeAt($index);
    }

    public function itemAt($index) {
        return $this->list->itemAt($index);
    }

    public function count() {
        return $this->list->count();
    }
}