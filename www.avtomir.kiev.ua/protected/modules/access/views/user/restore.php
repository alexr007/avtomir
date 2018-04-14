<?php
/* @var $this UserController */
/* @var $form CActiveForm  */
/* @var $model FormUserRestore */

$this->pageTitle=Yii::app()->name . ' - Restore Password for User';

$this->breadcrumbs=array(
	'User'=>array('/access/user/admin'),
	'Restore',
);
?>
<h2>User Password Restore</h2>
<p>Please fill out the following:</p>
<div class="form">
<?php
	$form=$this->beginWidget('CActiveForm', [
	'id'=>'form-u-restore',
	'enableClientValidation'=>true,
	'focus'=>[$model,'email'],
	'clientOptions'=>[
			'validateOnSubmit'=>true,
		],
	]);
?>
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<div class="row">
		<?php 
			echo $form->labelEx($model,'email');
			echo $form->textField($model,'email');
			echo $form->error($model,'email');
		?>
	</div>

	<div class="row buttons">
		<?php
			echo CHtml::submitButton('Restore');
		?>
	</div>

	<div class="row">
		<?php
			echo CHtml::link('Login',['login']);
			echo "&nbsp&nbsp|&nbsp&nbsp";
			echo CHtml::link('Create',['create']);
		?>
	</div>

<?php
	$this->endWidget();
?>

<?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }
?>

</div><!-- form -->
