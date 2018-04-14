<?php
/* @var $this CountryController */
/* @var $model DbCountry */

$this->breadcrumbs=array(
	'Db Countries'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List DbCountry', 'url'=>array('index')),
	array('label'=>'Manage DbCountry', 'url'=>array('admin')),
);
?>

<h1>Create DbCountry</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>