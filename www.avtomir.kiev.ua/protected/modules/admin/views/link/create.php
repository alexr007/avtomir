<?php
/* @var $this DbLinkController */
/* @var $model DbLink */

$this->breadcrumbs=array(
	'Db Links'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Manage DbLink', 'url'=>array('admin')),
);
?>

<h1>Create DbLink</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>