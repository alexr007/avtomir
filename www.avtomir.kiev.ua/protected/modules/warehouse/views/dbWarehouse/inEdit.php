<div class="form">

<?php 
	$form=$this->beginWidget('CActiveForm', [
//		'id'=>'form-edit-in',
	]);
	
	$this->renderPartial('_inEdit', [
				'form'=>$form,
				'model'=>$model,
			]);
?>

	<div class="row buttons">
	<?php
		echo CHtml::submitButton('Save'
			/*
				['id'=>'btnSave',
			'onclick'=>'js:btn_save();']
			 * 
			 */
		);
	?>
	</div>
	
<?php 
	$this->endWidget();
