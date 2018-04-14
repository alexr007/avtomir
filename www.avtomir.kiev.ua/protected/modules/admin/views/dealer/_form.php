<?php
/* @var $this DealerController */
/* @var $model DbDealer */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'db-dealer-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'dl_name'); ?>
		<?php echo $form->textField($model,'dl_name'); ?>
		<?php echo $form->error($model,'dl_name'); ?>
	</div>

	<div class="row">
		<?php
        echo $form->labelEx($model,'dl_country');
        //echo $form->textField($model,'dl_country');
        echo $form->dropDownList($model,'dl_country',
            $country::listData(['show_all'=>false,'show_empty'=>true]),
            ['style'=>'width:173px']);
        echo $form->error($model,'dl_country');
		?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'dl_comment'); ?>
		<?php echo $form->textField($model,'dl_comment'); ?>
		<?php echo $form->error($model,'dl_comment'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'dl_showas'); ?>
		<?php echo $form->textField($model,'dl_showas'); ?>
		<?php echo $form->error($model,'dl_showas'); ?>
	</div>

	<div class="row">
		<?php
        echo $form->labelEx($model,'dl_enabled');
		//echo $form->textField($model,'dl_enabled');
        echo $form->dropDownList($model,'dl_enabled',
            ['1'=>'Yes', '0'=>'No'],
            ['style'=>'width:173px']);
		echo $form->error($model,'dl_enabled');
		?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->