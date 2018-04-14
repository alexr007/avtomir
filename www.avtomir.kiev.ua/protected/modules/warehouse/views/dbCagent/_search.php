<?php
/* @var $this DbCagentsController */
/* @var $model DbCagents */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'ca_id'); ?>
		<?php echo $form->textField($model,'ca_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ca_name'); ?>
		<?php echo $form->textField($model,'ca_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ca_type'); ?>
		<?php echo $form->textField($model,'ca_type'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->