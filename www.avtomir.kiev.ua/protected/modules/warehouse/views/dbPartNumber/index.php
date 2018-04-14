<?php
/* @var $this DbPartNumberController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Db Part Numbers',
);

$this->menu=array(
	array('label'=>'Create DbPartNumber', 'url'=>array('create')),
	array('label'=>'Manage DbPartNumber', 'url'=>array('admin')),
);
?>

<h1>Db Part Numbers</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
