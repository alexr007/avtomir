<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RuntimeSession
 *
 * @author alexr
 */
class RuntimeSession implements IRuntimeSession{
	
	public function id() {
		return Yii::app()->session->sessionID;
	}
	
}
