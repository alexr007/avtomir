<?php
/* @var $this UsersController */
/* @var $model Users */

$this->breadcrumbs=array(
	'Users'=>array('admin'),
	$model->u_id=>array('view','id'=>$model->u_id),
	'Update',
);

$this->menu=array(
	array('label'=>'Create Users', 'url'=>array('create')),
	array('label'=>'View Users', 'url'=>array('view', 'id'=>$model->u_id)),
	array('label'=>'Manage Users', 'url'=>array('admin')),
);
?>

<h2>Edit User <b><?php echo $model->u_login; ?></b> details: </h2>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>