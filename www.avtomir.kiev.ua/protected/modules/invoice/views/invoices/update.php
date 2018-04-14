<?php
/* @var $this InvoicesController */
/* @var $model DbInvoice */

$this->breadcrumbs=array(
	'Db Invoices'=>array('index'),
	$model->in_id=>array('view','id'=>$model->in_id),
	'Update',
);

$this->menu=array(
	array('label'=>'Create DbInvoice', 'url'=>array('create')),
	array('label'=>'Manage DbInvoice', 'url'=>array('index')),
);
?>

<h1>Update DbInvoice <?php echo $model->in_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>