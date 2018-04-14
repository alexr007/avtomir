<?php
/* @var $this UserProfileFieldsController */
/* @var $model UserProfileFields */
/* @var $form CActiveForm */
?>

<div class="form">

<?php 
	$form=$this->beginWidget('CActiveForm', array(
		'id'=>'user-profile-fields-form',
		// Please note: When you enable ajax validation, make sure the corresponding
		// controller action is handling ajax validation correctly.
		// There is a call to performAjaxValidation() commented in generated controller code.
		// See class documentation of CActiveForm for details on this.
		'enableAjaxValidation'=>false,
	)); 
	$style = ['style'=>'width:200px'];
?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php 
			echo $form->labelEx($model,'upf_type');
			echo $form->dropDownList($model,'upf_type',
					['1'=>'int', '2'=>'str'],
					$style);
			echo $form->error($model,'upf_type');
		?>
	</div>

	<div class="row">
		<?php 
			echo $form->labelEx($model,'upf_name');
			echo $form->textField($model,'upf_name');
			echo $form->error($model,'upf_name');
		?>
	</div>

	<div class="row">
		<?php 
			echo $form->labelEx($model,'upf_description');
			echo $form->textField($model,'upf_description');
			echo $form->error($model,'upf_description');
		?>
	</div>

	<div class="row">
		<?php 
			echo $form->labelEx($model,'upf_default');
			echo $form->textField($model,'upf_default');
			echo $form->error($model,'upf_default');
		?>
	</div>

	<div class="row">
		<?php 
			echo $form->labelEx($model,'upf_enable');
			echo $form->dropDownList($model,'upf_enable',
					['1'=>'Yes', '0'=>'No'],
					$style);
			echo $form->error($model,'upf_enable');
		?>
	</div>

	<div class="row">
		<?php 
			echo $form->labelEx($model,'upf_order');
			echo $form->textField($model,'upf_order');
			echo $form->error($model,'upf_order');
		?>
	</div>

	<div class="row">
		<?php 
			echo $form->labelEx($model,'upf_show');
			echo $form->dropDownList($model,'upf_show',
					['1'=>'Yes', '0'=>'No'],
					$style);
			echo $form->error($model,'upf_show');
		?>
	</div>

	<div class="row buttons">
		<?php
			echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save');
		?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->