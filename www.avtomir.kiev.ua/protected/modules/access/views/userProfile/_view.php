<?php
/* @var $this UserProfileController */
/* @var $data UserProfile */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('up_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->up_id), array('view', 'id'=>$data->up_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('up_user')); ?>:</b>
	<?php echo CHtml::encode($data->up_user); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('up_field')); ?>:</b>
	<?php echo CHtml::encode($data->up_field); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('up_value')); ?>:</b>
	<?php echo CHtml::encode($data->up_value); ?>
	<br />


</div>