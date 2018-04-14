<?php
/* @var $this DbPartNumberController */
/* @var $model DbPartNumber */

$this->breadcrumbs=array(
	'Db Part Numbers'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List DbPartNumber', 'url'=>array('index')),
	array('label'=>'Create DbPartNumber', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#db-part-number-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Db Part Numbers</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	//'id'=>'db-part-number-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'pn_id',
		['name'=>'pn_vendor',
		'value'=>'$data->vendorS',
		],
		['name'=>'pn_number',
		'value'=>'$data->numberS',
		],
		'pn_weight',
		array(
			'class'=>'CButtonColumn',
			'template'=>'{update} {delete}',
		),
	),
)); ?>
