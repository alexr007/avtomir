<?php
/* @var $this ParameterController */
/* @var $model DbParameter */

$this->breadcrumbs=array(
	'Db Parameters'=>array('index'),
	$model->pa_id=>array('view','id'=>$model->pa_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List DbParameter', 'url'=>array('index')),
	array('label'=>'Create DbParameter', 'url'=>array('create')),
	array('label'=>'View DbParameter', 'url'=>array('view', 'id'=>$model->pa_id)),
	array('label'=>'Manage DbParameter', 'url'=>array('admin')),
);
?>

<h1>Update DbParameter <?php echo $model->pa_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>