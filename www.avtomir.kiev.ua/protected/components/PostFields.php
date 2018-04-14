<?php
class PostFields {
	private $items;
	
	public function __construct($items) {
		$this->items = new CList();
		if (is_array($items)) {
			foreach ($items as $item) {
				if (trim($item)) {
					if (!$this->items->contains($item)) {
						$this->items->add($item);
					}
				}
			}
		}
	}

	public function items() {
		return $this->items;
	}
		
	public function contains($item) {
		return $this->items->contains($item);
	}
	
	public function toString() {
        $s = "fields:[";
        $delim = "";
        foreach ($this->items as $item) {
            $s .= $delim;
            $s .= $item->toString();
            $delim = ", ";
        }
        $s .= "]";
        return $s;
	}
	
	public function count() {
		return $this->items->count();
	}
}
