<?php
/* @var $this UserController */
/* @var $form CActiveForm  */
/* @var $model FormUserProfile */

$this->pageTitle=Yii::app()->name . ' - User Profile';

$this->breadcrumbs=array(
	'User'=>array('/users/user'),
	'Profile',
);

Yii::app()->clientScript->registerScript('search', "
$('.button-password').click(function(){
	$('.form-password-change').toggle();
	return false;
});
");

?>
<h2>Edit user profile</h2>
<p>Please fill/edit the following:</p>
<div class="form">
<?php
	$form=$this->beginWidget('CActiveForm', [
	'id'=>'form-u-profile',
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
			$style = ['style'=>'width:240px'];
			echo $form->labelEx($model,'login');
			echo $form->textField($model,'login',$style);
			echo $form->error($model,'login');
		?>
	</div>

	<div class="row">
		<?php 
			echo $form->labelEx($model,'email');
			echo $form->textField($model,'email',$style);
			echo $form->error($model,'email');
		?>
	</div>

	<div class="row">
		<?php 
			echo $form->labelEx($model,'firstName');
			echo $form->textField($model,'firstName',$style);
			echo $form->error($model,'firstName');
		?>
	</div>
	
	<div class="row">
		<?php 
			echo $form->labelEx($model,'lastName');
			echo $form->textField($model,'lastName',$style);
			echo $form->error($model,'lastName');
		?>
	</div>
	
	<?php echo CHtml::link('Password change','#',array('class'=>'button-password')); ?>
	<div class="form-password-change" style="display:none">
	
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

	</div><!-- change password -->

	<div class="row buttons">
		<?php
			echo CHtml::submitButton('Update the profile');
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
