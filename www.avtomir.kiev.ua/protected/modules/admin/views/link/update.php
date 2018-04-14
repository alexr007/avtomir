<?php
/* @var $this DbLinkController */
/* @var $model DbLink */

$this->breadcrumbs=array(
	'Db Links'=>array('index'),
	$model->ln_id=>array('view','id'=>$model->ln_id),
	'Update',
);

$this->menu=array(
	array('label'=>'Create DbLink', 'url'=>array('create')),
	array('label'=>'Manage DbLink', 'url'=>array('index')),
);
?>

<h1>Update DbLink <?php echo $model->ln_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>