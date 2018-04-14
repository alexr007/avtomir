<?php
/* @var $this UserProfileController */
/* @var $model UserProfile */

$this->breadcrumbs=array(
	'User Profiles'=>array('index'),
	'Manage',
);

$this->menu=array(
);

?>

<h2>Manage User Profiles</h2>

<?php
	$form=$controller->beginWidget('CActiveForm', [
	]); 

	$columns = [
		[	'name'=>'up_user',
            'value'=>'$data->upUser->u_login',
			'filter'=>CHtml::dropDownList(
						'UserProfile[up_user]',
						$model->up_user, 
						$users
					),	
		],
		[	'name'=>'up_field',
            'value'=>'$data->upField->upf_name',
			'filter'=>CHtml::dropDownList(
						'UserProfile[up_field]',
						$model->up_field, 
						$user_profile_fields
					),	
		],
		/*
        [	'name'=>'up_value',
            'value'=>'$data->fieldValue' // это реальное значение даже если LookupCombobox
		],
		*/
		// here is editable value to be
		[	'header'=>'Value',
			'type'=>'raw',
			//'name'=>'up_value',
            //'value'=>'$data->fieldValue', // это реальное значение даже если LookupCombobox
			'value'=>'CHtml::textField("UserProfile[$data->up_id][up_value]",$data->fieldValue,["style"=>"width:45px"])',
			//'htmlOptions'=>['width'=>'49px'], 
		],
		
		// кнопки
		[	'class'=>'CButtonColumn',
		],
	];
	
	// если debug - добавляем колонку
	if (Yii::app()->user->checkAccess('task_debug')) 
		$columns = 	array_merge(
		[
			[	'name'=>'up_id', 
				'htmlOptions'=>['width'=>'30px'], 
			],
		], $columns);
	
		
	$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'user-profile-grid',
		'dataProvider'=>$model->search(),
		'filter'=>$model,
		'columns'=>$columns, // columns
	)); 
	
	echo CHtml::button('Submit',
			['submit'=>['submitChanges'],
			'id'=>'buttonSubmitChanges']
		);
	
	$controller->endWidget();
