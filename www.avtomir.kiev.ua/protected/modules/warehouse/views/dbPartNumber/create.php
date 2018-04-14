<?php
/* @var $this DbPartNumberController */
/* @var $model DbPartNumber */

$this->breadcrumbs=array(
	'Db Part Numbers'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List DbPartNumber', 'url'=>array('index')),
	array('label'=>'Manage DbPartNumber', 'url'=>array('admin')),
);
?>

<h1>Create DbPartNumber</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>