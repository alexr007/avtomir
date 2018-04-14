<?php
/* @var $this InvoicesController */
/* @var $model DbInvoice */

$this->breadcrumbs=array(
	'Db Invoices'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Create DbInvoice', 'url'=>array('create')),
);
?>

<h2>Manage Invoices</h2>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'db-invoice-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
	        [
                'type'=>'raw',
                'value'=>'$data->inDealer->name',
                'header'=>'Dealer',
                'filter'=>CHtml::dropDownList(
                    'DbInvoice[in_dealer]',
                    $model->in_dealer,
                    DbDealer::listData()
                ),
            ],
        'in_number',
        'in_comment',
        [
            'name'=>'in_date',
            'header'=>'Date'
        ],
        [
            'class'=>'CButtonColumn',
        ],
	),
)); ?>
