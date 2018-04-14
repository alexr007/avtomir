<?php

class Timer {
    
    private $_timer;
    
    public function __construct()
    {
        $this->_timer = microtime(true);
    }

    public function time()
    {
        if ($this->_timer == null) {
            $this->_timer = microtime(true);
            return false;
        }
        else {
            $time = microtime(true) - $this->_timer;
            $this->_timer == null;
            return $time;
        }
    }
    
}