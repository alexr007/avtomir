<?php
/* @var $this DbOutgoingController */
/* @var $model DbOutgoing */

$this->breadcrumbs=array(
	'Db Outgoings'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List DbOutgoing', 'url'=>array('index')),
	array('label'=>'Manage DbOutgoing', 'url'=>array('admin')),
);
?>

<h1>Create DbOutgoing</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>