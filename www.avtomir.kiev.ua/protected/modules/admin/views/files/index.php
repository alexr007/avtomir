<?php
	$this->breadcrumbs=[];
	$this->menu=[];
?>

<h2>Files upload/download service</h2>

<?php 
	$this->widget('zii.widgets.grid.CGridView', [
		'id'=>'files-grid',
		'dataProvider'=>$model->search(),
		//'filter'=>$items,
		'columns'=>[
			[
				'header'=>'Id',
				'name'=>'fi_id',
			],
			[
				'header'=>'orig',
				'name'=>'fi_original_name',
			],
			[
				'header'=>'given',
				'name'=>'fi_given_name',
			],
			[
				'header'=>'ext',
				'name'=>'fi_ext',
			],
			[
				'name'=>'fi_path_alias',
			],
			[
				'name'=>'dateS',
			],
			[
				'name'=>'fi_category',
				'value'=>'$data->fi_category == File::T_XLS ? "xls" : ($data->fi_category == File::T_IMG ? "img" : "")',
			],
			/*
			[
				'header'=>'path',
				'value'=>'$data->fullFilePath',
			],
			*/
			[
				'class'=>'CLinkColumn',
				'header'=>'Download',
				'label'=>'link',
				'urlExpression'=>'"download?id=".$data->fi_id',
            ],
			[
				'class'=>'CButtonColumn',
				'template'=>'{delete}',
			]
		],
	]);

	$form = $this->beginWidget('CActiveForm',[
				'id' => 'upload-form',
				'enableAjaxValidation' => false,
/*				'clientOptions'=>[
					'validateOnChange'=>true,
					'validateOnSubmit' => true,
				],
*/				
				'htmlOptions' => ['enctype' => 'multipart/form-data'],
		]);
	
		echo CHtml::activeFileField($model, 'image');
		//$form->error($model, 'image');
		echo "<br><br>";
		echo CHtml::submitButton('Upload File Now!');
	
	$this->endWidget();
	