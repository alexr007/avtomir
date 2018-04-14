<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PriceFinderConfiguration
 *
 * @author alexr
 */
class PriceFinderConfiguration {
	private $alias;
	private $class;
	private $access;

	public function __construct($alias, $class, $access) {
	    $this->alias = $alias;
	    $this->class = $class;
	    $this->access = $access;
    }

    public function alias()
    {
        return $this->alias;
    }

    public function className()
    {
        return $this->class;
    }

    public function access()
    {
        return $this->access;
    }
}
