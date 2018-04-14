<?php
/* @var $this DbIncomingController */
/* @var $model DbIncoming */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'in_id'); ?>
		<?php echo $form->textField($model,'in_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'in_date'); ?>
		<?php echo $form->textField($model,'in_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'in_cagent'); ?>
		<?php echo $form->textField($model,'in_cagent'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'in_pn'); ?>
		<?php echo $form->textField($model,'in_pn'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'in_qty'); ?>
		<?php echo $form->textField($model,'in_qty'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'in_weight'); ?>
		<?php echo $form->textField($model,'in_weight',array('size'=>8,'maxlength'=>8)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'in_price'); ?>
		<?php echo $form->textField($model,'in_price',array('size'=>8,'maxlength'=>8)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->