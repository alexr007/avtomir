	<div id="mainmenu">
	<?php 
		$user = new RuntimeUser();
		$visible=$user->isAdmin();
		$module="/admin";
		
		$this->widget('zii.widgets.CMenu',[
//			'activeCssClass'=>'active',
//			'activateParents'=>true,
			'items'=>[
                ['label'=>'Upload Price','url'=>[$module.'/price/index'], 	'visible'=>$visible],
				['label'=>'FileControl','url'=>[$module.'/files/index'], 	'visible'=>$visible],
				['label'=>'WWW Links',	'url'=>[$module.'/link/index'], 	'visible'=>$visible],
				['label'=>'Parameters',	'url'=>[$module.'/parameter'], 		'visible'=>$visible],
				['label'=>'Login History',	'url'=>[$module.'/loginAttempt'],'visible'=>$visible],
				['label'=>'Search History',	'url'=>[$module.'/searchHistory'],'visible'=>$visible],
                ['label'=>'Countries',	'url'=>[$module.'/country'],'visible'=>$visible],
                ['label'=>'Dealers',	'url'=>[$module.'/dealer'],'visible'=>$visible],
			],
		]);
	?>
	</div>
