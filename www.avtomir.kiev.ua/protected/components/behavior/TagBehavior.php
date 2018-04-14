<?php

class TagBehavior extends FlagBehavior {

	public function getHome()
	{
		return $this->flag1;
	}
	
	public function setHome($value = false)
	{
		$this->flag1 = $value;
		return $this;
	}
	
    /// HomeS
	public function getHomeS()
    {
		return $this->home == 1 ? "Home" : "";
    }

}