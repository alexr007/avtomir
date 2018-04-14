	<div id="mainmenu">
	<?php 
		$module="/warehouse";
		$user = new RuntimeUser();
		
		$this->widget('zii.widgets.CMenu',[
			'items'=>[
				['label'=>'Stock',		'url'=>[$module.'/dbWarehouse/stock'],	'visible'=>$user->isOperator()],
				['label'=>'Agents',		'url'=>[$module.'/dbCagent/index'],	'visible'=>$user->isOperator()],
				['label'=>'Vendors',	'url'=>[$module.'/dbVendor/admin'],	'visible'=>$user->isOperator()],
				['label'=>'Numbers',	'url'=>[$module.'/dbNumber/admin'],	'visible'=>$user->isOperator()],
				['label'=>'PartNumbers','url'=>[$module.'/dbPartNumber/admin'],	'visible'=>$user->isOperator()],
				['label'=>'Incoming',	'url'=>[$module.'/dbWarehouse/inAll'],	'visible'=>$user->isOperator()],
				['label'=>'Outgoing',	'url'=>[$module.'/dbWarehouse/outAll'],	'visible'=>$user->isOperator()],
				['label'=>'Carts',		'url'=>[$module.'/dbCart'],	'visible'=>$user->isOperator()],
				['label'=>'Orders',		'url'=>[$module.'/dbOrder'],'visible'=>$user->isOperator()],
			],
		]);
	?>
	</div>
