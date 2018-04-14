<?php
/* @var $this UserProfileController */
/* @var $model UserProfile */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-profile-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
));
	$ro=['readonly'=>true];
	$roDD=['disabled'=>'disabled'];
?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php
			echo $form->labelEx($model,'up_user');
			echo $form->dropDownList($model,'up_user',
				$users,
				$roDD);
			echo $form->error($model,'up_user');
		?>
	</div>

	<div class="row">
		<?php
			echo $form->labelEx($model,'up_field');
			echo $form->dropDownList($model,'up_field',
				$user_profile_fields,
				$roDD
				);
			echo $form->error($model,'up_field');
		?>
	</div>

	<div class="row">
		<?php
			//VarDumper::dump($model->up_field);
			echo $form->labelEx($model,'up_value');
			switch ($model->up_field) {
				case 8 : // country ( COUNTRY )
					echo $form->dropDownList($model,'up_value',
						$countries, []);
					break;
				case 5 : // destination (COUNTRY + CITY)
					echo $form->dropDownList($model,'up_value',
						$destinations, []);
					break;
				case 9 : // default route (FORWARDING OPERATOR)
					echo $form->dropDownList($model,'up_value',
						$operators, []);
					break;
				case 10 : // default method (AVIA, SEA)
					echo $form->dropDownList($model,'up_value',
						$shippingmethods, []);
					break;
				case 12 : // working company
					echo $form->dropDownList($model,'up_value',
						$companies, []);
					break;
				default : // other string/int - non Lookup fields
					echo $form->textField($model,'up_value');
					break;
			}
			echo $form->error($model,'up_value');
		?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->