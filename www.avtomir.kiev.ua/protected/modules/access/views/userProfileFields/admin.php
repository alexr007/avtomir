<?php
/* @var $this UserProfileFieldsController */
/* @var $model UserProfileFields */

$this->breadcrumbs=array(
	'User Profile Fields'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Create UserProfileFields', 'url'=>array('create')),
);

?>

<h2>Manage User Profile Fields</h2>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-profile-fields-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		[	'name'=>'upf_id', 
			'htmlOptions'=>['width'=>'40px'], ],
		[	'name'=>'upf_type',
            'value'=>function($data) {
						if ($data->upf_type==1) return "int";
						if ($data->upf_type==2) return "str";
						return "";
					},
			'htmlOptions'=>['width'=>'40px'],
			'filter'=>CHtml::dropDownList(
						'UserProfileFields[upf_type]',
						$model->upf_type, 
						[''=>'All', '1'=>'int', '2'=>'str']
					),	
		],
		[	'name'=>'upf_name',
			'htmlOptions'=>['width'=>'130px'],
		],
		[	'name'=>'upf_description',
			'htmlOptions'=>['width'=>'250px'],
		],
		'upf_default',
	//	'upf_enable',
		[	'name'=>'upf_enable',
            'value'=>function($data) {
						return $data->upf_enable==1 ? "Yes" : "No";
					},
			'htmlOptions'=>['width'=>'40px'],
			'filter'=>CHtml::dropDownList(
						'UserProfileFields[upf_enable]',
						$model->upf_enable, 
						[''=>'All', '1'=>'Yes', '0'=>'No']
					),	
		],
		[	'name'=>'upf_order',
			'htmlOptions'=>['width'=>'40px'],
		],
		[	'name'=>'upf_show',
            'value'=>'$data->upf_show==1 ? "Yes" : "No"',
			'htmlOptions'=>['width'=>'40px'],
			'filter'=>CHtml::dropDownList(
						'UserProfileFields[upf_show]',
						$model->upf_show, 
						[''=>'All', '1'=>'Yes', '0'=>'No']
					),	
		],
		[
			'class'=>'CButtonColumn',
			'template'=>'{update} {delete}',
		],
	),
)); ?>
