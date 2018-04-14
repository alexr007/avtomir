<?php
/* @var $this CountryController */
/* @var $model DbCountry */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'co_id'); ?>
		<?php echo $form->textField($model,'co_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'co_name'); ?>
		<?php echo $form->textField($model,'co_name'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->