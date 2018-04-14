<?php
/* @var $this UserProfileController */
/* @var $model UserProfile */

$this->breadcrumbs=array(
	'User Profiles'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List UserProfile', 'url'=>array('index')),
	array('label'=>'Manage UserProfile', 'url'=>array('admin')),
);
?>

<h1>Create UserProfile</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>