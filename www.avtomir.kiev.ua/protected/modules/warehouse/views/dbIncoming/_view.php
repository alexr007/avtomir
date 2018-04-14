<?php
/* @var $this DbIncomingController */
/* @var $data DbIncoming */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('in_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->in_id), array('view', 'id'=>$data->in_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('in_date')); ?>:</b>
	<?php echo CHtml::encode($data->in_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('in_cagent')); ?>:</b>
	<?php echo CHtml::encode($data->in_cagent); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('in_pn')); ?>:</b>
	<?php echo CHtml::encode($data->in_pn); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('in_qty')); ?>:</b>
	<?php echo CHtml::encode($data->in_qty); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('in_weight')); ?>:</b>
	<?php echo CHtml::encode($data->in_weight); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('in_price')); ?>:</b>
	<?php echo CHtml::encode($data->in_price); ?>
	<br />


</div>