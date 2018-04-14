<?php
/* @var $this DbIncomingController */
/* @var $model DbIncoming */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'db-incoming-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'in_date'); ?>
		<?php echo $form->textField($model,'in_date'); ?>
		<?php echo $form->error($model,'in_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'in_cagent'); ?>
		<?php echo $form->textField($model,'in_cagent'); ?>
		<?php echo $form->error($model,'in_cagent'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'in_pn'); ?>
		<?php echo $form->textField($model,'in_pn'); ?>
		<?php echo $form->error($model,'in_pn'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'in_qty'); ?>
		<?php echo $form->textField($model,'in_qty'); ?>
		<?php echo $form->error($model,'in_qty'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'in_weight'); ?>
		<?php echo $form->textField($model,'in_weight',array('size'=>8,'maxlength'=>8)); ?>
		<?php echo $form->error($model,'in_weight'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'in_price'); ?>
		<?php echo $form->textField($model,'in_price',array('size'=>8,'maxlength'=>8)); ?>
		<?php echo $form->error($model,'in_price'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->