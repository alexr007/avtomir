<?php
/* @var $this DbVendorsController */
/* @var $model DbVendors */

$this->breadcrumbs=array(
	'Db Vendors'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List DbVendors', 'url'=>array('index')),
	array('label'=>'Manage DbVendors', 'url'=>array('admin')),
);
?>

<h1>Create DbVendors</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>