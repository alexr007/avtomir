<?php
/**
 * Created by PhpStorm.
 * User: alexr
 * Date: 16.02.2017
 * Time: 10:51
 */
class AMTReplaceParsed {
    private $origin;

    public function __construct($value) {
        $this->origin = $value;
    }

    /*
     * special handling for AMT ugly / trash response like this:
     * 'Part number 4884899AB was superceded by part number 4884899AC.'
     */
    public function value() {
        $ret= "";
        if ($this->origin) {
            $lastSpacePos = strrpos($this->origin, " ");
            $ret = substr($this->origin, $lastSpacePos, -1);
        }
        return $ret;
    }
}