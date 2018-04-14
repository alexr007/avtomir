<?php
/* @var $this DbVendorsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Db Vendors',
);

$this->menu=array(
	array('label'=>'Create DbVendors', 'url'=>array('create')),
	array('label'=>'Manage DbVendors', 'url'=>array('admin')),
);
?>

<h1>Db Vendors</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
