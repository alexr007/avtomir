<?php

class MGrab extends CFormModel
{
	private function clearDevTables()
	{
		$command = Yii::app()->db->createCommand();

		$sql_coomands = [
			'users',
			'user_loginattempts',
			'part_search_history', //+
			'user_loginattempts',
			'user_profile_fields',
			'user_profile',
			//'warehouse_order',
			//'warehouse_cart',
			//'part_number',
			'orders',
			'order_item',
		];
		
		foreach ($sql_coomands as $sql_line)
			$command->setText('delete from  '.$sql_line)->execute();
	}

	private function copyTables()
	{
		$sql = [
			'us'=>[ // users
					'order'=>'u_id',
					'sql_r' => 'select u_id, u_login, u_password, u_email, u_firstname, u_lastname, u_created, u_updated, u_lastvisit, u_passwordchange, u_status from users',
					'sql_w' => 'insert into users(u_id, u_login, u_password, u_email, u_firstname, u_lastname, u_created, u_updated, u_lastvisit, u_passwordchange, u_emailverified, u_active, u_disabled, u_status) '.
								'values (:u_id, :u_login, :u_password, :u_email, :u_firstname, :u_lastname, :u_created, :u_updated, :u_lastvisit, :u_passwordchange, false, true, false, :u_status)', 
					'seq' => 'users_u_id_seq', 
				], 
			'ula'=>[ 
					'order'=>'ul_id',
					'sql_r' => 'select ul_id, ul_userid, ul_performed, ul_successful, ul_session, ul_ipv4, ul_useragent, ul_login from user_loginattempts',
					'sql_w' => 'insert into user_loginattempts(ul_id, ul_userid, ul_performed, ul_successful, ul_session, ul_ipv4, ul_useragent, ul_login) '.
								'values (:ul_id, :ul_userid, :ul_performed, :ul_successful, :ul_session, :ul_ipv4, :ul_useragent, :ul_login)', 
					'seq' => 'user_loginattempts_ul_id_seq', 
				], 
			'psh'=>[ 
					'order'=>'psh_id',
					'sql_r' => 'select psh_id, psh_user, psh_search, psh_date from part_search_history',
					'sql_w' => 'insert into part_search_history(psh_id, psh_user, psh_search, psh_date) '.
								'values (:psh_id, :psh_user, :psh_search, :psh_date)',
					'seq' => 'check_price_history_cph_id_seq',
				],
			'upf'=>[ 
					'order'=>'upf_id', 
					'sql_r' => 'select upf_id, upf_type, upf_name, upf_description, upf_default, upf_enable, upf_order, upf_show from user_profile_fields',
					'sql_w' => 'insert into user_profile_fields(upf_id, upf_type, upf_name, upf_description, upf_default, upf_enable, upf_order, upf_show) '.
								'values (:upf_id, :upf_type, :upf_name, :upf_description, :upf_default, :upf_enable, :upf_order, :upf_show)',
					'seq' => 'user_profile_fields_upf_id_seq',
				], 
 			'up'=>[ 
					'order'=>'up_id', 
					'sql_r' => 'select up_id, up_user, up_field, up_value from user_profile',
					'sql_w' => 'insert into user_profile(up_id, up_user, up_field, up_value) '.
								'values (:up_id, :up_user, :up_field, :up_value)',
					'seq' => 'user_profile_up_id_seq',
				], 
 			'or'=>[ 
					'order'=>'o_id', 
					'sql_r' => 'select o_id, o_number, o_user, o_status, o_date_in, o_date_process, o_date_close, o_comment_user, o_comment_oper from orders',
					'sql_w' => 'insert into orders(o_id, o_number, o_user, o_status, o_date_in, o_date_process, o_date_close, o_comment_user, o_comment_oper) '.
								'values (:o_id, :o_number, :o_user, :o_status, :o_date_in, :o_date_process, :o_date_close, :o_comment_user, :o_comment_oper)',
					'seq' => 'orders_o_id_seq',
					'sql_seq2' => 'ALTER SEQUENCE public.order_number RESTART 22',
				], 
 			'ori'=>[ 
					'order'=>'oi_id', 
					'sql_r' => 'select oi_id, oi_order, oi_status, oi_ship_method, oi_dealer, oi_vendor, oi_number, oi_desc_en, oi_desc_ru, oi_depot, oi_qty, oi_price, oi_weight, oi_volume, oi_comment_user, oi_comment_oper, oi_date_process, oi_date_dealer_ship, oi_date_received, oi_date_shipped from order_item',
					'sql_w' => 'insert into order_item(oi_id, oi_order, oi_status, oi_ship_method, oi_dealer, oi_vendor, oi_number, oi_desc_en, oi_desc_ru, oi_depot, oi_qty, oi_price, oi_weight, oi_volume, oi_comment_user, oi_comment_oper, oi_date_process, oi_date_dealer_ship, oi_date_received, oi_date_shipped) '.
								'values (:oi_id, :oi_order, :oi_status, :oi_ship_method, :oi_dealer, :oi_vendor, :oi_number, :oi_desc_en, :oi_desc_ru, :oi_depot, :oi_qty, :oi_price, :oi_weight, :oi_volume, :oi_comment_user, :oi_comment_oper, :oi_date_process, :oi_date_dealer_ship, :oi_date_received, :oi_date_shipped)',
					'seq' => 'order_item_oi_id_seq',
				], 
			/*
			'tr'=>[ // trackings
					'order'=>'tr_id',
					'sql_r' => 'select tr_id, tr_carrier, tr_tracking, tr_status, tr_owner, tr_tag, tr_weight, tr_dimx, tr_dimy, tr_dimz, tr_comment_owner, tr_comment_operator, tr_status_date, tr_number, tr_method, tr_destination, tr_route from trackings',
					'sql_w' => 'insert into trackings (tr_id, tr_carrier, tr_tracking, tr_status, tr_owner, tr_tag, tr_weight, tr_dimx, tr_dimy, tr_dimz, tr_comment_owner, tr_comment_operator, tr_status_date, tr_number, tr_method, tr_destination, tr_route) '.
							'values (:tr_id, :tr_carrier, :tr_tracking, :tr_status, :tr_owner, :tr_tag, :tr_weight, :tr_dimx, :tr_dimy, :tr_dimz, :tr_comment_owner, :tr_comment_operator, :tr_status_date, :tr_number, :tr_method, :tr_destination, :tr_route)',
					'seq' => 'trackings_tr_id_seq',
					'sql_seq2' => 'ALTER SEQUENCE public.amtx_id RESTART 1034',
				],
			'pa'=>[ // pallet
					'order'=>'pl_id',
					'sql_r' => 'select pl_id, pl_number, pl_weight, pl_description, pl_comment, pl_status, pl_status_date from pallet',
					'sql_w' => 'insert into pallet(pl_id, pl_number, pl_weight, pl_description, pl_comment, pl_status, pl_status_date) '.
								'values (:pl_id, :pl_number, :pl_weight, :pl_description, :pl_comment, :pl_status, :pl_status_date)',
					'seq' => 'pallet_pl_id_seq',
					'sql_seq2' => 'ALTER SEQUENCE pallet_number RESTART 4',
				],
			'pi'=>[
					'order'=>'pi_id',
					'sql_r' => 'select pi_id, pi_pallet, pi_item, pi_date, pi_user from pallet_items',
					'sql_w' => 'insert into pallet_items(pi_id, pi_pallet, pi_item, pi_date, pi_user) '.
								'values (:pi_id, :pi_pallet, :pi_item, :pi_date, :pi_user)',
					'seq' => 'pallet_items_pi_id_seq',
				],
			'psh'=>[
					'order'=>'psh_id',
					'sql_r' => 'select psh_id, psh_pallet, psh_date, psh_status, psh_user from pallet_status_history',
					'sql_w' => 'insert into pallet_status_history(psh_id, psh_pallet, psh_date, psh_status, psh_user) '.
								'values (:psh_id, :psh_pallet, :psh_date, :psh_status, :psh_user)',
					'seq' => 'pallet_status_history_psh_id_seq',
				],
			'tsh'=>[
					'order'=>'sh_id',
					'sql_r' => 'select sh_id, sh_track_id, sh_date, sh_status, sh_user from tracking_status_history',
					'sql_w' => 'insert into tracking_status_history(sh_id, sh_track_id, sh_date, sh_status, sh_user) '.
								'values (:sh_id, :sh_track_id, :sh_date, :sh_status, :sh_user)',
					'seq' => 'status_history_sh_id_seq',
				],
			 * 
			 */

/* 			'us'=>[
					'order'=>'__', :
					'sql_r' => 'select __ from __',
					'sql_w' => 'insert into __(__) '.
								'values (__)',
					'seq' => '__',
				], 
*/
		];
		
		$command = Yii::app()->db->createCommand();
		$command_r = Yii::app()->db_prod->createCommand();
		
		foreach ($sql as $table=>$value) {
			$rows = $command_r->setText($value['sql_r'].' order by '.$value['order'])->queryAll();
			echo "$table...";
			
			foreach ($rows as $row) {
				if ($table=='ula') 
					$row['ul_successful'] = ($row['ul_successful']) ? "true" : "false";
				
				$command->setText($value['sql_w'])->execute($row);
			}
			
			reset($row);$maxval=current($row)+1;
			echo "<br>maxval:$maxval<br>";
			echo "done<br><br>";
			$command->setText('ALTER SEQUENCE '.$value['seq'].' RESTART '.$maxval)->execute();
			if ($table=='or') $command->setText($value['sql_seq2'])->execute();
		}
	}
	
	public function move()
	{
		$this->clearDevTables();
		$this->copyTables();
	}
	
}
