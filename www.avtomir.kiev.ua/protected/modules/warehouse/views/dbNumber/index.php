<?php
/* @var $this DbNumbersController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Db Numbers',
);

$this->menu=array(
	array('label'=>'Create DbNumbers', 'url'=>array('create')),
	array('label'=>'Manage DbNumbers', 'url'=>array('admin')),
);
?>

<h1>Db Numbers</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
