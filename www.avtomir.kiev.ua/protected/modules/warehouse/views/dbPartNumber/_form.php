<?php
/* @var $this DbPartNumberController */
/* @var $model DbPartNumber */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	//'id'=>'db-part-number-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	//'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php
			echo $form->labelEx($model,'pn_vendor');
			echo $form->dropDownList($model,'pn_vendor',
				DbVendor::listData(['show_all'=>false]),
				['style'=>'width:173px']);
			echo $form->error($model,'pn_vendor');
		?>
	</div>

	<div class="row">
		<?php
			echo $form->labelEx($model,'pn_number');
			echo $form->dropDownList($model,'pn_number',
				DbNumber::listData(['show_all'=>false]),
				['style'=>'width:173px']);
			echo $form->error($model,'pn_number');
		?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pn_weight'); ?>
		<?php echo $form->textField($model,'pn_weight',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'pn_weight'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->