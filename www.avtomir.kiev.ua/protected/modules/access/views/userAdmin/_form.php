<?php
/* @var $this UsersController */
/* @var $model Users */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'u_login'); ?>
		<?php echo $form->textField($model,'u_login'); ?>
		<?php echo $form->error($model,'u_login'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'newPassword'); ?>
		<?php echo $form->textField($model,'newPassword'); ?>
		<?php echo $form->error($model,'newPassword'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'u_email'); ?>
		<?php echo $form->textField($model,'u_email'); ?>
		<?php echo $form->error($model,'u_email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'u_firstname'); ?>
		<?php echo $form->textField($model,'u_firstname'); ?>
		<?php echo $form->error($model,'u_firstname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'u_lastname'); ?>
		<?php echo $form->textField($model,'u_lastname'); ?>
		<?php echo $form->error($model,'u_lastname'); ?>
	</div>

	<div class="row">
		<?php echo $form->checkBox($model,'u_emailverified'); ?>
		<?php echo $form->labelEx($model,'u_emailverified'); ?>
		<?php echo $form->error($model,'u_emailverified'); ?>
	</div>

	<div class="row">
		<?php echo $form->checkBox($model,'u_active'); ?>
		<?php echo $form->labelEx($model,'u_active'); ?>
		<?php echo $form->error($model,'u_active'); ?>
	</div>

	<div class="row">
		<?php echo $form->checkBox($model,'u_disabled'); ?>
		<?php echo $form->labelEx($model,'u_disabled'); ?>
		<?php echo $form->error($model,'u_disabled'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->