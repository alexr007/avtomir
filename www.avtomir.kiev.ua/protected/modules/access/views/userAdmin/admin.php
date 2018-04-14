<?php
/* @var $this UsersController */
/* @var $model Users */

$this->breadcrumbs=array(
	'Users'=>array('admin'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Create Users', 'url'=>array('create')),
);

?>

<h2>Manage Users</h2>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>


<?php 
	date_default_timezone_set('Europe/Kiev');
	//date_default_timezone_set('America/New_York');

	$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'users-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		['name'=>'u_id', 'htmlOptions'=>['width'=>'30px'], ],
		'u_login',
		'u_email',
		'u_firstname',
		'u_lastname',
		[	'name'=>'u_created',
//			'type' => 'datetime',
			'type' => 'raw',
			'value' => 'date("Y-m-d G:i", strtotime($data->u_created))',
		//date("Y-m-d h:i",$data->u_created)
		],
		[	'name'=>'u_disabled', 
			'htmlOptions'=>['width'=>'30px'],
            'type'=>'raw',
            'value'=>'$data->u_disabled ? "Disabled" : "Ok"',
			'filter'=>CHtml::dropDownList(
						'User[u_disabled]',
						$model->u_disabled, 
						[
							''=>'All',
							'1'=>'Disabled',
							'0'=>'Ok',
						]
					),	
			
        ],
		
		/*
		'u_updated',
		'u_lastvisit',
		'u_passwordchange',
		'u_emailverified',
		'u_active',
		'u_password',
		'u_activation_key',
		'u_otp_secret',
		'u_otp_code',
		'u_otp_counter',
		*/
		array(
			'class'=>'CButtonColumn',
//			'template'=>'{update} {delete}',
		),
	),
)); ?>
