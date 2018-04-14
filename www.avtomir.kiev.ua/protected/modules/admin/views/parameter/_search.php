<?php
/* @var $this ParameterController */
/* @var $model DbParameter */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'pa_id'); ?>
		<?php echo $form->textField($model,'pa_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pa_type'); ?>
		<?php echo $form->textField($model,'pa_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pa_key'); ?>
		<?php echo $form->textField($model,'pa_key'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pa_value'); ?>
		<?php echo $form->textField($model,'pa_value'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pa_desc'); ?>
		<?php echo $form->textField($model,'pa_desc'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pa_category'); ?>
		<?php echo $form->textField($model,'pa_category'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->