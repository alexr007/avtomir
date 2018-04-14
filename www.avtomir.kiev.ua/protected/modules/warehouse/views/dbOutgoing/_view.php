<?php
/* @var $this DbOutgoingController */
/* @var $data DbOutgoing */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('out_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->out_id), array('view', 'id'=>$data->out_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('out_date')); ?>:</b>
	<?php echo CHtml::encode($data->out_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('out_cagent')); ?>:</b>
	<?php echo CHtml::encode($data->out_cagent); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('out_price')); ?>:</b>
	<?php echo CHtml::encode($data->out_price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('out_qty')); ?>:</b>
	<?php echo CHtml::encode($data->out_qty); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('out_link')); ?>:</b>
	<?php echo CHtml::encode($data->out_link); ?>
	<br />


</div>