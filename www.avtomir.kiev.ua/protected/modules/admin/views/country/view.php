<?php
/* @var $this CountryController */
/* @var $model DbCountry */

$this->breadcrumbs=array(
	'Db Countries'=>array('index'),
	$model->co_id,
);

$this->menu=array(
	array('label'=>'List DbCountry', 'url'=>array('index')),
	array('label'=>'Create DbCountry', 'url'=>array('create')),
	array('label'=>'Update DbCountry', 'url'=>array('update', 'id'=>$model->co_id)),
	array('label'=>'Delete DbCountry', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->co_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage DbCountry', 'url'=>array('admin')),
);
?>

<h1>View DbCountry #<?php echo $model->co_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'co_id',
		'co_name',
	),
)); ?>
