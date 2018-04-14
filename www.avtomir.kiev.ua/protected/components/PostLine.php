<?php

class PostLine{
	private $id;
	private $items;
	
	public function __construct($id) {
		$this->id = $id;
		$this->items = new CList();
	}

	function id() {
		return $this->id;
	}
	
	private function items() {
		return $this->items;
	}
	
	public function count() {
		return $this->items->count();
	}
	
	public function add(PostItem $item) {
		$this->items->add($item);
	}
	
	public function byKey($key) {
		$r = '';
		foreach ($this->items as $item) {
			if ($item->name() == $key) {
				$r = $item->value();
			break;
			}
		}
		return $r;
	}
	
	public function toString() {
		$s = "line items:[";
		$delim = "";
		foreach ($this->items as $item) {
			$s .= $delim;
			$s .= $item->toString();
            $delim = ", ";
		}
		$s .= "]";
		return $s;
	}
	
	public function equals(CActiveRecord $record) {
		$equals=true;
		foreach ($this->items() as $field) {
			if ($record->{$field->name()} != $this->byKey($field->name()))	{
				$equals=false;
				break;
			}
		}
		return $equals;
	}
	
	public function apply(CActiveRecord $record) {
		foreach ($this->items() as $field) {
			$record->{$field->name()} = $this->byKey($field->name());
		}
	}
}
