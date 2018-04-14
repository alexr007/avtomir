<?php

class TrackingBehavior extends FlagBehavior {

	public function getHold()
	{
		return $this->flag1;
	}
	
	public function setHold($value = false)
	{
		$this->flag1 = $value;
		return $this;
	}
	
}
