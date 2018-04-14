<?php
/* @var $this DbNumbersController */
/* @var $model DbNumbers */

$this->breadcrumbs=array(
	'Db Numbers'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List DbNumbers', 'url'=>array('index')),
	array('label'=>'Manage DbNumbers', 'url'=>array('admin')),
);
?>

<h1>Create DbNumbers</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>