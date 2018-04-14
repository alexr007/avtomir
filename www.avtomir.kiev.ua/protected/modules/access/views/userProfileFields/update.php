<?php
/* @var $this UserProfileFieldsController */
/* @var $model UserProfileFields */

$this->breadcrumbs=array(
	'User Profile Fields'=>array('index'),
	$model->upf_id=>array('view','id'=>$model->upf_id),
	'Update',
);

$this->menu=array(
	array('label'=>'Create UserProfileFields', 'url'=>array('create')),
	array('label'=>'Manage UserProfileFields', 'url'=>array('admin')),
);
?>

<h2>Update UserProfileFields <?php echo $model->upf_id; ?></h2>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>