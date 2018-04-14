<?php
/* @var $this UserProfileController */
/* @var $model UserProfile */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'up_id'); ?>
		<?php echo $form->textField($model,'up_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'up_user'); ?>
		<?php echo $form->textField($model,'up_user'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'up_field'); ?>
		<?php echo $form->textField($model,'up_field'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'up_value'); ?>
		<?php echo $form->textField($model,'up_value'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->