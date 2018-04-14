<?php
/* @var $this DbPartNumberController */
/* @var $model DbPartNumber */

$this->breadcrumbs=array(
	'Db Part Numbers'=>array('index'),
	$model->pn_id,
);

$this->menu=array(
	array('label'=>'List DbPartNumber', 'url'=>array('index')),
	array('label'=>'Create DbPartNumber', 'url'=>array('create')),
	array('label'=>'Update DbPartNumber', 'url'=>array('update', 'id'=>$model->pn_id)),
	array('label'=>'Delete DbPartNumber', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->pn_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage DbPartNumber', 'url'=>array('admin')),
);
?>

<h1>View DbPartNumber #<?php echo $model->pn_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'pn_id',
		'pn_vendor',
		'pn_number',
		'pn_weight',
	),
)); ?>
