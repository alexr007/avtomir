<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FormatMessage
 *
 * @author alexr
 */
class FormatMessage implements IFormatMessage {
	
	private $_type;
	
	public function __construct($type)
	{
		$this->_type = $type;
	}
	
	public function glue()
	{
		switch ($this->_type)
		{
			case "html" : return "<br>";
			case "text" : return "\n";
			default : return "";
		}
	}
}
