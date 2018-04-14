<?php
/* @var $this DbCagentsController */
/* @var $data DbCagents */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('ca_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->ca_id), array('view', 'id'=>$data->ca_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ca_name')); ?>:</b>
	<?php echo CHtml::encode($data->ca_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ca_type')); ?>:</b>
	<?php echo CHtml::encode($data->ca_type); ?>
	<br />


</div>