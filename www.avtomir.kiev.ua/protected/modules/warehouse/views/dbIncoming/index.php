<?php
/* @var $this DbIncomingController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Db Incomings',
);

$this->menu=array(
	array('label'=>'Create DbIncoming', 'url'=>array('create')),
	array('label'=>'Manage DbIncoming', 'url'=>array('admin')),
);
?>

<h1>Db Incomings</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
