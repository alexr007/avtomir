<?php
/* @var $this DbOutgoingController */
/* @var $model DbOutgoing */

$this->breadcrumbs=array(
	'Db Outgoings'=>array('index'),
	$model->out_id,
);

$this->menu=array(
	array('label'=>'List DbOutgoing', 'url'=>array('index')),
	array('label'=>'Create DbOutgoing', 'url'=>array('create')),
	array('label'=>'Update DbOutgoing', 'url'=>array('update', 'id'=>$model->out_id)),
	array('label'=>'Delete DbOutgoing', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->out_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage DbOutgoing', 'url'=>array('admin')),
);
?>

<h1>View DbOutgoing #<?php echo $model->out_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'out_id',
		'out_date',
		'out_cagent',
		'out_price',
		'out_qty',
		'out_link',
	),
)); ?>
