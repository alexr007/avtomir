	<div id="mainmenu">
	<?php 
		$module="/invoice";
		$user = new RuntimeUser();
		
		$this->widget('zii.widgets.CMenu',[
			'items'=>[
                ['label'=>'Invoices',	'url'=>[$module.'/invoices/index'],	'visible'=>$user->isOperator()],
                ['label'=>'Invoice Parse',	'url'=>[$module.'/invoiced/parse'],	'visible'=>$user->isOperator()],
			],
		]);
	?>
	</div>
