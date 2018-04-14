<?php
/* @var $this DbOutgoingController */
/* @var $model DbOutgoing */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'out_id'); ?>
		<?php echo $form->textField($model,'out_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'out_date'); ?>
		<?php echo $form->textField($model,'out_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'out_cagent'); ?>
		<?php echo $form->textField($model,'out_cagent'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'out_price'); ?>
		<?php echo $form->textField($model,'out_price',array('size'=>8,'maxlength'=>8)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'out_qty'); ?>
		<?php echo $form->textField($model,'out_qty'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'out_link'); ?>
		<?php echo $form->textField($model,'out_link'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->