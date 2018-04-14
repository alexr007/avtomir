<?php
/* @var $this UserController */
/* @var $form CActiveForm  */
/* @var $model UserLoginForm */

$this->pageTitle=Yii::app()->name . ' - Login User';

$this->breadcrumbs=array(
	'User'=>array('/access/user/admin'),
	'Login',
);
?>
<h2>Login User</h2>
<p>Please fill out the following:</p>
<div class="form">
<?php
	$form=$this->beginWidget('CActiveForm', [
	'id'=>'form-u-login',
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

	<div class="row rememberMe">
		<?php
			echo $form->checkBox($model,'rememberMe');
			echo $form->label($model,'rememberMe');
			echo $form->error($model,'rememberMe');
		?>
	</div>

	<div class="row buttons">
		<?php
			echo CHtml::submitButton('Login');
		?>
	</div>

	<div class="row">
		<?php
			echo CHtml::link('Create',['create']);
			echo "&nbsp&nbsp|&nbsp&nbsp";
			echo CHtml::link('Restore',['restore']);
		?>
	</div>
<?php
	$this->endWidget();
?>

</div><!-- form -->
