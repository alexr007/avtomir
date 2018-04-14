<?php

class MoveQueryToCart {
	
	public function __construct() {
		$this->run();
	}
	
	public function run() {
		// user selection - from POST
		$partListToOrder = new PartListToOrder($_POST, 'DbPartPrice', ['pp_cnt','pp_dtype'], new CList());
		// part_price - previous from db
		$session = new RuntimeSession();
		$dbParts = DbPartPrice::model()->findAllByAttributes(['pp_session'=>$session->id()]);
		
		// put inco cart with POST data
		foreach ($dbParts as $dbPart)
			if ($partListToOrder->contains($dbPart->getId()))
			{
				$beCartItem = $partListToOrder->byId($dbPart->getId());
				
				$partToCart = new DbCart();
				$partToCart->fillWith([
						'ct_dealer' => $dbPart->pp_dealer,
						'ct_vendor' => $dbPart->pp_vendor,
						'ct_number' => $dbPart->pp_number,
						'ct_desc_en' => $dbPart->pp_desc_en,
						'ct_desc_ru' => $dbPart->pp_desc_ru,
						'ct_depot' => $dbPart->pp_depot,
						'ct_price' => $dbPart->pp_price,
						'ct_weight' => $dbPart->pp_weight,
						'ct_volume' => $dbPart->pp_volume,
						'ct_date' => $dbPart->pp_date,
//						'ct_comment_user' => $dbPart->pp_comment_user,
//						'ct_comment_oper' => $dbPart->pp_comment_oper,
					]);
				$partToCart->fillWith([
						'ct_quantity' => $beCartItem->quantity(),
						'ct_dtype' => $beCartItem->deliveryType(),
					]);
				$partToCart->save();
			}
		// crear part_price after add to cart
		new FoundResultsDeleteBySession($session);
		
	}
}
