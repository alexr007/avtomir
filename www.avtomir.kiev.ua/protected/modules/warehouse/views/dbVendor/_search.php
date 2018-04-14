<?php
/* @var $this DbVendorsController */
/* @var $model DbVendors */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'v_id'); ?>
		<?php echo $form->textField($model,'v_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'v_name'); ?>
		<?php echo $form->textField($model,'v_name'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->