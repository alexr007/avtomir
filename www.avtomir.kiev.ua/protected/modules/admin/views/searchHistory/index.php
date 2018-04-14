<?php

	$this->breadcrumbs=[];
	$this->menu=[];

?>

<h2>User Search History</h2>

<?php
	$this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$history->search(),
	'filter'=>$history,
	'columns'=>[
		[
			'header'=>'Date',
			'value'=>'$data->date',
		],
		'psh_search',
		//'psh_user',
		[
			'header'=>'User',
			'value'=>'$data->pshUser->name',
			'filter'=>CHtml::dropDownList(
					'DbPartSearchHistory[psh_user]',
					$history->psh_user, 
					DbUser::listData()
				),	
		],
		array(
			'class'=>'CButtonColumn',
			'template'=>'{delete}',
		),
	],
));
