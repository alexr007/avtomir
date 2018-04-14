<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CUniqueNonEmplyList
 *
 * @author alexr
 */
class CUniqueNonEmplyList extends CList {
	
	public function add($item)
	{
		if ($item)
			if (!$this->contains($item))
				return parent::add($item);
			
		return false;
	}
	
	public function toText($delimiter = "\n")
	{
		return implode($delimiter, $this->toArray());
	}
}
