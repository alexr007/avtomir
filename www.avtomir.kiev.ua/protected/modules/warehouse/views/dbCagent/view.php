<?php
/* @var $this DbCagentsController */
/* @var $model DbCagents */

$this->breadcrumbs=array(
	'Db Cagents'=>array('index'),
	$model->ca_id,
);

$this->menu=array(
	array('label'=>'List DbCagents', 'url'=>array('index')),
	array('label'=>'Create DbCagents', 'url'=>array('create')),
	array('label'=>'Update DbCagents', 'url'=>array('update', 'id'=>$model->ca_id)),
	array('label'=>'Delete DbCagents', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->ca_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage DbCagents', 'url'=>array('admin')),
);
?>

<h1>View DbCagents #<?php echo $model->ca_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'ca_id',
		'ca_name',
		'ca_type',
	),
)); ?>
