<?php
/* @var $this DbCagentsController */
/* @var $model DbCagents */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'db-cagents-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php
			echo $form->labelEx($model,'ca_name');
			echo $form->textField($model,'ca_name');
			echo $form->error($model,'ca_name');
		?>
	</div>

	<div class="row">
		<?php
			echo $form->labelEx($model,'ca_type');
			echo $form->dropDownList($model,'ca_type',
					DbCagentType::listData(['show_all'=>false]),
					['style'=>'width:173px']);
			echo $form->error($model,'ca_type');
		?>
	</div>

	<div class="row">
		<?php
			echo $form->labelEx($model,'ca_userid');
			echo $form->dropDownList($model,'ca_userid',
					// это текущий login
					$model->getCurrentIdName()+
					// это доступные логины
					DbUsersNotAssigned::listData(['show_all'=>false,'show_empty'=>true]),
					['style'=>'width:173px']);
			echo $form->error($model,'ca_userid');
		?>
	</div>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->