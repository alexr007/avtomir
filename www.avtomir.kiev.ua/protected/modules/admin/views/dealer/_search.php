<?php
/* @var $this DealerController */
/* @var $model DbDealer */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'dl_id'); ?>
		<?php echo $form->textField($model,'dl_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dl_name'); ?>
		<?php echo $form->textField($model,'dl_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dl_country'); ?>
		<?php echo $form->textField($model,'dl_country'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dl_comment'); ?>
		<?php echo $form->textField($model,'dl_comment'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dl_showas'); ?>
		<?php echo $form->textField($model,'dl_showas'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dl_enabled'); ?>
		<?php echo $form->textField($model,'dl_enabled'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->