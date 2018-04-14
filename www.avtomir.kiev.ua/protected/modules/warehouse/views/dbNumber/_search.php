<?php
/* @var $this DbNumbersController */
/* @var $model DbNumbers */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'n_id'); ?>
		<?php echo $form->textField($model,'n_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'n_number'); ?>
		<?php echo $form->textField($model,'n_number'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->