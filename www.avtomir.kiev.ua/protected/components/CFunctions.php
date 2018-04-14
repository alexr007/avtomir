<?php

function getEbayItem($string) {
	if (preg_match('/\d{12}/', $string, $match)) {
		return $match[0];
	} else 
		return null;
}