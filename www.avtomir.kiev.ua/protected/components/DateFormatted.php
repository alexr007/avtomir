<?php

class DateFormatted {
	
	const DEFAULT_FORMAT = "d.m.Y";
	
	private $origin;
	private $format;
	
	public function __construct($dt, $fmt = self::DEFAULT_FORMAT) {
		$this->origin = $dt;
		$this->format = $fmt;
	}

    public function value()
    {
        return $this->date();
    }

    public function date()
	{
		return $this->dmy();
	}
	
	private function dmy()
	{
		return $this->origin == null ? "" :
			date($this->format, strtotime($this->origin));
	}
	
}
