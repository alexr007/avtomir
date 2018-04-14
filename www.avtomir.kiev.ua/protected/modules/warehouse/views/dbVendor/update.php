<?php
/* @var $this DbVendorsController */
/* @var $model DbVendors */

$this->breadcrumbs=array(
	'Db Vendors'=>array('index'),
	$model->v_id=>array('view','id'=>$model->v_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List DbVendors', 'url'=>array('index')),
	array('label'=>'Create DbVendors', 'url'=>array('create')),
	array('label'=>'View DbVendors', 'url'=>array('view', 'id'=>$model->v_id)),
	array('label'=>'Manage DbVendors', 'url'=>array('admin')),
);
?>

<h1>Update DbVendors <?php echo $model->v_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>