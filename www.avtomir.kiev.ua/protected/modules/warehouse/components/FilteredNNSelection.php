<?php

class FilteredNNSelection {
	
	private $origin;
	private $filtered;
	
	public function __construct($orig) {
		$this->origin = $orig;
		$this->filtered = [];
		
		$this->filter();
	}
	
	/* чистит исходный массив (обычно получаемый из multy-row form)
	 * data[id1][key1] data[id1][key2] data[id1][keyN]
	 * data[id2][key1] data[id2][key2] data[id2][keyN]
	 * ...
	 * data[idN][key1] data[idN][key2] data[idN][keyN]
	 * по правилу: в результат попадают только те data[id] 
	 * у которых ВСЕ ключи key1..keyN должны иметь значения.
	 */
	
	private function filter()
	{
		foreach ($this->origin as $k=>$item)
		{
			$row = [];
			$origLen = count($item);
			$filtLen = 0;
			
			foreach ($item as $key=>$value)
				if (trim($value))
				{
					$row[$key] = $value;
					$filtLen++;
				}
			
			if ($filtLen == $origLen)
				$this->filtered[$k] = $row;
		}
	}
	
	public function getData()
	{
		return $this->filtered;
	}
	
	public function count()
	{
		return count($this->filtered);
	}
	
	public function isEmpty()
	{
		return $this->count() == 0;
	}
}
