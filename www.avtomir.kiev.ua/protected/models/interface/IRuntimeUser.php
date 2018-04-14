<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author alexr
 */
interface IRuntimeUser {
    
    public function isGuest ();
    public function id();
    public function name();
    
}