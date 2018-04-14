<?php
/* @var $this DbCagentsController */
/* @var $model DbCagents */

$this->breadcrumbs=array(
	'Db Cagents'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List DbCagents', 'url'=>array('index')),
	array('label'=>'Manage DbCagents', 'url'=>array('admin')),
);
?>

<h1>Create DbCagents</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>