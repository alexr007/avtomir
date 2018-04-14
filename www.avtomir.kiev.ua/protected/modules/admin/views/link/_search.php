<?php
/* @var $this DbLinkController */
/* @var $model DbLink */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'ln_id'); ?>
		<?php echo $form->textField($model,'ln_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ln_name'); ?>
		<?php echo $form->textField($model,'ln_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ln_url'); ?>
		<?php echo $form->textField($model,'ln_url'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->