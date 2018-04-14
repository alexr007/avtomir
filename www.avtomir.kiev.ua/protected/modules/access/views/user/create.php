<?php
/* @var $this UserController */
/* @var $form CActiveForm  */
/* @var $model UserCreateForm */

$this->pageTitle=Yii::app()->name . ' - Create User';

$this->breadcrumbs=array(
	'User'=>array('/access/user/admin'),
	'Create',
);
?>
<h2>Create User</h2>
<p>Please fill out the following:</p>
<div class="form">
<?php
	$form=$this->beginWidget('CActiveForm', [
	'id'=>'form-u-create',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
	'focus'=>[$model,'login'],
	'clientOptions'=>[
			'validateOnSubmit'=>true,
		],
	]);
?>
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<div class="row">
		<?php 
			echo $form->labelEx($model,'login');
			echo $form->textField($model,'login');
			echo $form->error($model,'login');
		?>
	</div>

	<div class="row">
		<?php
			echo $form->labelEx($model,'password');
			echo $form->passwordField($model,'password');
			echo $form->error($model,'password');
		?>
	</div>

	<div class="row">
		<?php
			echo $form->labelEx($model,'password2');
			echo $form->passwordField($model,'password2');
			echo $form->error($model,'password2');
		?>
	</div>

	<div class="row buttons">
		<?php
			echo CHtml::submitButton('Create');
		?>
	</div>

	<div class="row">
		<?php
			echo CHtml::link('Login',['login']);
			echo "&nbsp&nbsp|&nbsp&nbsp";
			echo CHtml::link('Restore',['restore']);
		?>
	</div>

<?php
	$this->endWidget();
?>

</div><!-- form -->
