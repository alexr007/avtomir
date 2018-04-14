<?php
/* @var $this DbOutgoingController */
/* @var $model DbOutgoing */

$this->breadcrumbs=array(
	'Db Outgoings'=>array('index'),
	$model->out_id=>array('view','id'=>$model->out_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List DbOutgoing', 'url'=>array('index')),
	array('label'=>'Create DbOutgoing', 'url'=>array('create')),
	array('label'=>'View DbOutgoing', 'url'=>array('view', 'id'=>$model->out_id)),
	array('label'=>'Manage DbOutgoing', 'url'=>array('admin')),
);
?>

<h1>Update DbOutgoing <?php echo $model->out_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>