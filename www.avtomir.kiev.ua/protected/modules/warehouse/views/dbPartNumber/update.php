<?php
/* @var $this DbPartNumberController */
/* @var $model DbPartNumber */

$this->breadcrumbs=array(
	'Db Part Numbers'=>array('index'),
	$model->pn_id=>array('view','id'=>$model->pn_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List DbPartNumber', 'url'=>array('index')),
	array('label'=>'Create DbPartNumber', 'url'=>array('create')),
	array('label'=>'View DbPartNumber', 'url'=>array('view', 'id'=>$model->pn_id)),
	array('label'=>'Manage DbPartNumber', 'url'=>array('admin')),
);
?>

<h1>Update DbPartNumber <?php echo $model->pn_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>