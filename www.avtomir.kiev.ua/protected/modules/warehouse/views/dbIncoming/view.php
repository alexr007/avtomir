<?php
/* @var $this DbIncomingController */
/* @var $model DbIncoming */

$this->breadcrumbs=array(
	'Db Incomings'=>array('index'),
	$model->in_id,
);

$this->menu=array(
	array('label'=>'List DbIncoming', 'url'=>array('index')),
	array('label'=>'Create DbIncoming', 'url'=>array('create')),
	array('label'=>'Update DbIncoming', 'url'=>array('update', 'id'=>$model->in_id)),
	array('label'=>'Delete DbIncoming', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->in_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage DbIncoming', 'url'=>array('admin')),
);
?>

<h1>View DbIncoming #<?php echo $model->in_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'in_id',
		'in_date',
		'in_cagent',
		'in_pn',
		'in_qty',
		'in_weight',
		'in_price',
	),
)); ?>
