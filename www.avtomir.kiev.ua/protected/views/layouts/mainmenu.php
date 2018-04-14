	<div id="mainmenu">
		<?php 
		
		$user = new RuntimeUser();
		$show = $user->isAdmin() || $user->isOperator();

		$newOrdersFound = new NewOrderFound();
		$this->widget('zii.widgets.CMenu',[
		// --------------------------------------
			//'activeCssClass'=>'active',
			//'activateParents'=>true,
			'items'=>[
				['label'=>'access', 'url'=>['/access'], 'visible'=>$show],
				['label'=>'admin', 'url'=>['/admin'], 'visible'=>$show],
				['label'=>'price', 'url'=>['/price']],
				['label'=>'warehouse', 'url'=>['/warehouse'], 'visible'=>$user->isOperator()],
                ['label'=>'invoice', 'url'=>['/invoice'], 'visible'=>$user->isOperator()],
                ['label'=>'finance', 'url'=>['/finance'], 'visible'=>$user->isOperator()],

				['label'=>'Login', 'url'=>['/access/user/login'], 'visible'=>$user->isGuest()],

				['label'=>'Logout ('.Yii::app()->user->name.')',
									'url'=>['/access/user/logout'], 'visible'=>!$user->isGuest()],
				['label'=>'',		'url'=>[$newOrdersFound->moduleLink()],	'visible'=>$newOrdersFound->found()&&$show, 'itemOptions'=>$newOrdersFound->htmlOptions()],
			],
		// --------------------------------------
		]);
//VarDumper::dump(Yii::app()->controller->id);
		?>
	</div><!-- mainmenu -->
