<?php
/* @var $this DealerController */
/* @var $model DbDealer */

$this->breadcrumbs=array(
	'Db Dealers'=>array('index'),
	$model->dl_id,
);

$this->menu=array(
	array('label'=>'List DbDealer', 'url'=>array('index')),
	array('label'=>'Create DbDealer', 'url'=>array('create')),
	array('label'=>'Update DbDealer', 'url'=>array('update', 'id'=>$model->dl_id)),
	array('label'=>'Delete DbDealer', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->dl_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage DbDealer', 'url'=>array('admin')),
);
?>

<h1>View DbDealer #<?php echo $model->dl_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'dl_id',
		'dl_name',
		'dl_country',
		'dl_comment',
		'dl_showas',
		'dl_enabled',
	),
)); ?>
