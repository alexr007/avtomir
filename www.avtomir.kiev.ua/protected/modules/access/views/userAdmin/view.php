<?php
/* @var $this UsersController */
/* @var $model Users */

$this->breadcrumbs=array(
	'Users'=>array('admin'),
	$model->u_id,
);

$this->menu=array(
	array('label'=>'Create Users', 'url'=>array('create')),
	array('label'=>'Update Users', 'url'=>array('update', 'id'=>$model->u_id)),
	array('label'=>'Delete Users', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->u_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Users', 'url'=>array('admin')),
);
?>

<h2>View User's details: <b><?php echo $model->u_login; ?></b></h2>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'u_id',
		'u_login',
		'u_password',
		'u_email',
		'u_firstname',
		'u_lastname',
		'u_created',
		'u_updated',
		'u_lastvisit',
		'u_passwordchange',
		'u_emailverified',
		[	'name'=>'u_active', 
            'type'=>'raw',
            'value'=>$model->u_active ? "Yes" : "No",
        ],
		[	'name'=>'u_disabled', 
            'type'=>'raw',
            'value'=>$model->u_disabled ? "Disabled" : "No",
        ],
	),
)); ?>
