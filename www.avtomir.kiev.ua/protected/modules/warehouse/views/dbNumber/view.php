<?php
/* @var $this DbNumbersController */
/* @var $model DbNumbers */

$this->breadcrumbs=array(
	'Db Numbers'=>array('index'),
	$model->n_id,
);

$this->menu=array(
	array('label'=>'List DbNumbers', 'url'=>array('index')),
	array('label'=>'Create DbNumbers', 'url'=>array('create')),
	array('label'=>'Update DbNumbers', 'url'=>array('update', 'id'=>$model->n_id)),
	array('label'=>'Delete DbNumbers', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->n_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage DbNumbers', 'url'=>array('admin')),
);
?>

<h1>View DbNumbers #<?php echo $model->n_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'n_id',
		'n_number',
	),
)); ?>
