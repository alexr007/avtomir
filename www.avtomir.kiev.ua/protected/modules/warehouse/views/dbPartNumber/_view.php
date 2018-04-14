<?php
/* @var $this DbPartNumberController */
/* @var $data DbPartNumber */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('pn_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->pn_id), array('view', 'id'=>$data->pn_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pn_vendor')); ?>:</b>
	<?php echo CHtml::encode($data->pn_vendor); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pn_number')); ?>:</b>
	<?php echo CHtml::encode($data->pn_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pn_weight')); ?>:</b>
	<?php echo CHtml::encode($data->pn_weight); ?>
	<br />


</div>