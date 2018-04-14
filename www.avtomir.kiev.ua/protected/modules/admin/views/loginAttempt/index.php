<?php
/* @var $this LoginAttemptController */
/* @var $model DbUserLoginAttempt */

$this->breadcrumbs=array(
	'Db User Login Attempts'=>array('index'),
	'Manage',
);

$this->menu=[];
?>

<h2>User Login Attempts</h2>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'db-user-login-attempt-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		//'ul_id',
		//'ul_userid',
		[
			'value'=>'$data->date',
		],
		[	'value'=>'',
			'htmlOptions'=>['width'=>'120px'], 
			'cssClassExpression'=>'$data->ul_successful ? "item-ok" : "item-err"',
		],
		[
			'value'=>'$data->ip',
		],
		//'ul_useragent',
		'ul_login',
		array(
			'class'=>'CButtonColumn',
			'template'=>'{view} {delete}',
		),
	),
));
