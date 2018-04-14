<?php
/* @var $this DealerController */
/* @var $model DbDealer */

$this->breadcrumbs=array(
	'Db Dealers'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List DbDealer', 'url'=>array('index')),
	array('label'=>'Manage DbDealer', 'url'=>array('admin')),
);
?>

<h1>Create DbDealer</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>