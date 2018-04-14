<?php
/* @var $this CountryController */
/* @var $model DbCountry */

$this->breadcrumbs=array(
	'Db Countries'=>array('index'),
	$model->co_id=>array('view','id'=>$model->co_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List DbCountry', 'url'=>array('index')),
	array('label'=>'Create DbCountry', 'url'=>array('create')),
	array('label'=>'View DbCountry', 'url'=>array('view', 'id'=>$model->co_id)),
	array('label'=>'Manage DbCountry', 'url'=>array('admin')),
);
?>

<h1>Update DbCountry <?php echo $model->co_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>