<?php
/* @var $this DbIncomingController */
/* @var $model DbIncoming */

$this->breadcrumbs=array(
	'Db Incomings'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List DbIncoming', 'url'=>array('index')),
	array('label'=>'Create DbIncoming', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#db-incoming-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Db Incomings</h1>

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
	'id'=>'db-incoming-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'in_id',
		'in_date',
		'in_cagent',
		'in_pn',
		'in_qty',
		'in_weight',
		/*
		'in_price',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
