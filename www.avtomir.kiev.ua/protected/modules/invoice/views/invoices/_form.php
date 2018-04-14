<?php
/* @var $this InvoicesController */
/* @var $model DbInvoice */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'db-invoice-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'in_dealer'); ?>
		<?php echo $form->textField($model,'in_dealer'); ?>
		<?php echo $form->error($model,'in_dealer'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'in_number'); ?>
		<?php echo $form->textField($model,'in_number'); ?>
		<?php echo $form->error($model,'in_number'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'in_comment'); ?>
		<?php echo $form->textField($model,'in_comment'); ?>
		<?php echo $form->error($model,'in_comment'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'in_date'); ?>
		<?php echo $form->textField($model,'in_date'); ?>
		<?php echo $form->error($model,'in_date'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->