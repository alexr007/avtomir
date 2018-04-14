<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PriceLogger
 *
 * @author alexr
 */
class PriceLogger {
	
	public function __construct($value, IPutToHistory $logger)
	{
		$logger->putToHistory($value, new RuntimeUser);
	}
	
}
