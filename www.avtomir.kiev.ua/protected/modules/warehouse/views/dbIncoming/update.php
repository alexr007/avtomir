<?php
/* @var $this DbIncomingController */
/* @var $model DbIncoming */

$this->breadcrumbs=array(
	'Db Incomings'=>array('index'),
	$model->in_id=>array('view','id'=>$model->in_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List DbIncoming', 'url'=>array('index')),
	array('label'=>'Create DbIncoming', 'url'=>array('create')),
	array('label'=>'View DbIncoming', 'url'=>array('view', 'id'=>$model->in_id)),
	array('label'=>'Manage DbIncoming', 'url'=>array('admin')),
);
?>

<h1>Update DbIncoming <?php echo $model->in_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>