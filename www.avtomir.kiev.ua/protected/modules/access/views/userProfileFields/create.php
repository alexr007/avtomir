<?php
/* @var $this UserProfileFieldsController */
/* @var $model UserProfileFields */

$this->breadcrumbs=array(
	'User Profile Fields'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Manage UserProfileFields', 'url'=>array('admin')),
);
?>

<h2>Create UserProfileFields</h2>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>