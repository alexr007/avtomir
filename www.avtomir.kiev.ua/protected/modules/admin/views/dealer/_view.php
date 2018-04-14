<?php
/* @var $this DealerController */
/* @var $data DbDealer */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('dl_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->dl_id), array('view', 'id'=>$data->dl_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dl_name')); ?>:</b>
	<?php echo CHtml::encode($data->dl_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dl_country')); ?>:</b>
	<?php echo CHtml::encode($data->dl_country); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dl_comment')); ?>:</b>
	<?php echo CHtml::encode($data->dl_comment); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dl_showas')); ?>:</b>
	<?php echo CHtml::encode($data->dl_showas); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dl_enabled')); ?>:</b>
	<?php echo CHtml::encode($data->dl_enabled); ?>
	<br />


</div>