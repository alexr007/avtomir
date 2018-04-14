<?php
/* @var $this ParameterController */
/* @var $model DbParameter */

$this->breadcrumbs=array(
	'Db Parameters'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List DbParameter', 'url'=>array('index')),
	array('label'=>'Manage DbParameter', 'url'=>array('admin')),
);
?>

<h1>Create DbParameter</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>