<?php

/**
 * Class FlagCss
 *
 * return the CSS,
 * corresponding to dealer
 * table @dealer
 * field @dl_id
 *
 */
class FlagCss {
	
	private $dealerid;
	
	public function __construct($dealerid) {
		$this->dealerid = (int)$dealerid;
	}
	
	public function value() {
		switch ($this->dealerid) {
			case 1 : return "flag-usa";
			case 2 : return "flag-uae";
			case 3 : return "flag-ukr";
            case 4 : return "flag-ger";
		}
	}
}
