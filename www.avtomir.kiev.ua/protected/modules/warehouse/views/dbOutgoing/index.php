<?php
/* @var $this DbOutgoingController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Db Outgoings',
);

$this->menu=array(
	array('label'=>'Create DbOutgoing', 'url'=>array('create')),
	array('label'=>'Manage DbOutgoing', 'url'=>array('admin')),
);
?>

<h1>Db Outgoings</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
