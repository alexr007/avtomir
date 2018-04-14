<?php
/* @var $this DbIncomingController */
/* @var $model DbIncoming */

$this->breadcrumbs=array(
	'Db Incomings'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List DbIncoming', 'url'=>array('index')),
	array('label'=>'Manage DbIncoming', 'url'=>array('admin')),
);
?>

<h1>Create DbIncoming</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>