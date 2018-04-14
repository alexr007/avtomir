<div id="mainmenu">
	<?php 
		$module="/access";
		$defRoute="/admin";
		$visible=!Yii::app()->user->isGuest;
		$this->widget('zii.widgets.CMenu',[
			'items'=>[
				['label'=>'Users',			'url'=>[$module.'/userAdmin'.$defRoute],	'visible'=>$visible],
				['label'=>'Roles Assignment',	'url'=>['/rbac'],'visible'=>$visible],
				['label'=>'User\'s Profile Fields',	'url'=>[$module.'/userProfileFields'.$defRoute],	'visible'=>$visible],
				['label'=>'User\'s Profile',	'url'=>[$module.'/userProfile'.$defRoute],	'visible'=>$visible],
			],
		]);
	?>
</div>
