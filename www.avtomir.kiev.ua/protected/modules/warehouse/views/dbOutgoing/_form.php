<?php
/* @var $this DbOutgoingController */
/* @var $model DbOutgoing */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'db-outgoing-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'out_date'); ?>
		<?php echo $form->textField($model,'out_date'); ?>
		<?php echo $form->error($model,'out_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'out_cagent'); ?>
		<?php echo $form->textField($model,'out_cagent'); ?>
		<?php echo $form->error($model,'out_cagent'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'out_price'); ?>
		<?php echo $form->textField($model,'out_price',array('size'=>8,'maxlength'=>8)); ?>
		<?php echo $form->error($model,'out_price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'out_qty'); ?>
		<?php echo $form->textField($model,'out_qty'); ?>
		<?php echo $form->error($model,'out_qty'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'out_link'); ?>
		<?php echo $form->textField($model,'out_link'); ?>
		<?php echo $form->error($model,'out_link'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->