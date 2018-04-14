<?php
/* @var $this ParameterController */
/* @var $model DbParameter */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'db-parameter-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'pa_type'); ?>
		<?php echo $form->textField($model,'pa_type'); ?>
		<?php echo $form->error($model,'pa_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pa_key'); ?>
		<?php echo $form->textField($model,'pa_key'); ?>
		<?php echo $form->error($model,'pa_key'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pa_value'); ?>
		<?php echo $form->textField($model,'pa_value'); ?>
		<?php echo $form->error($model,'pa_value'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pa_desc'); ?>
		<?php echo $form->textField($model,'pa_desc'); ?>
		<?php echo $form->error($model,'pa_desc'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pa_category'); ?>
		<?php echo $form->textField($model,'pa_category'); ?>
		<?php echo $form->error($model,'pa_category'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->