	<div id="mainmenu">
	<?php 
		$module="/price";
		$user = new RuntimeUser();
		
		$this->widget('zii.widgets.CMenu',[
			'items'=>[
				['label'=>'Stock Search',	'url'=>[$module.'/warehoused'],	'visible'=>true],
				['label'=>'Parts Search',	'url'=>[$module.'/priced'],		'visible'=>true],
				
				['label'=>'Cart',			'url'=>[$module.'/cart'],'visible'=>!$user->isGuest()],
				['label'=>'Orders',			'url'=>[$module.'/order'],		'visible'=>!$user->isGuest()],
                ['label'=>'OrderItems',		'url'=>[$module.'/order/newitems'],	'visible'=>$user->isOperator()],
			],
		]);
	?>
	</div>
