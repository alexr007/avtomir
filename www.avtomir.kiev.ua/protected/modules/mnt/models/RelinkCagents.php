<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RelinkCagents
 *
 * @author alexr
 */
class RelinkCagents {
	
	public function run() {
		$orders = DbOrder::model()->findAll();

		foreach ($orders as $order) {
			$cagent = DbCagent::model()->findByAttributes(['ca_userid'=>$order->o_cagent]);
			$order->o_cagent = $cagent->ca_id;
			$order->save();
		}
	}
}
