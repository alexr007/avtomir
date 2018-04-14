<?php
/* @var $this DbVendorsController */
/* @var $model DbVendors */

$this->breadcrumbs=array(
	'Db Vendors'=>array('index'),
	$model->v_id,
);

$this->menu=array(
	array('label'=>'List DbVendors', 'url'=>array('index')),
	array('label'=>'Create DbVendors', 'url'=>array('create')),
	array('label'=>'Update DbVendors', 'url'=>array('update', 'id'=>$model->v_id)),
	array('label'=>'Delete DbVendors', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->v_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage DbVendors', 'url'=>array('admin')),
);
?>

<h1>View DbVendors #<?php echo $model->v_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'v_id',
		'v_name',
	),
)); ?>
