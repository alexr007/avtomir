<?php
/* @var $this DbPartNumberController */
/* @var $model DbPartNumber */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'pn_id'); ?>
		<?php echo $form->textField($model,'pn_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pn_vendor'); ?>
		<?php echo $form->textField($model,'pn_vendor'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pn_number'); ?>
		<?php echo $form->textField($model,'pn_number'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pn_weight'); ?>
		<?php echo $form->textField($model,'pn_weight',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->