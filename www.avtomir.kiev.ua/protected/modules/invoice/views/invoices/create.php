<?php
/* @var $this InvoicesController */
/* @var $model DbInvoice */

$this->breadcrumbs=array(
	'Db Invoices'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Manage DbInvoice', 'url'=>array('index')),
);
?>

<h1>Create DbInvoice</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>