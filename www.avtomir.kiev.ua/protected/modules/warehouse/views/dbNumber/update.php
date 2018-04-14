<?php
/* @var $this DbNumbersController */
/* @var $model DbNumbers */

$this->breadcrumbs=array(
	'Db Numbers'=>array('index'),
	$model->n_id=>array('view','id'=>$model->n_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List DbNumbers', 'url'=>array('index')),
	array('label'=>'Create DbNumbers', 'url'=>array('create')),
	array('label'=>'View DbNumbers', 'url'=>array('view', 'id'=>$model->n_id)),
	array('label'=>'Manage DbNumbers', 'url'=>array('admin')),
);
?>

<h1>Update DbNumbers <?php echo $model->n_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>