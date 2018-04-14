<?php
/* @var $this DbCagentsController */
/* @var $model DbCagents */

$this->breadcrumbs=array(
	'Db Cagents'=>array('index'),
	$model->ca_id=>array('view','id'=>$model->ca_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List DbCagents', 'url'=>array('index')),
	array('label'=>'Create DbCagents', 'url'=>array('create')),
	array('label'=>'View DbCagents', 'url'=>array('view', 'id'=>$model->ca_id)),
	array('label'=>'Manage DbCagents', 'url'=>array('admin')),
);
?>

<h1>Update DbCagents <?php echo $model->ca_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>