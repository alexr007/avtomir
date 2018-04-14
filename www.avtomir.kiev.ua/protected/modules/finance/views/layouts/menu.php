	<div id="mainmenu">
	<?php 
		$module="/finance";
		$user = new RuntimeUser();
		
		$this->widget('zii.widgets.CMenu',[
			'items'=>[
                ['label'=>'Balance',		'url'=>[$module.'/balance/index'],	'visible'=>$user->isOperator()],
                ['label'=>'Payments',		'url'=>[$module.'/payments/index'],	'visible'=>$user->isOperator()],
				['label'=>'Money',		'url'=>[$module.'/money/index'],	'visible'=>$user->isOperator()],
			],
		]);
	?>
	</div>
