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
interface IRuntimeUserRole {
    
    // all functions
    public function isScrum ();
    // all admin functions
    public function isAdmin ();
    // all manager functions
    public function isOperator ();
    // only user functions
    public function isClient ();
    
}
