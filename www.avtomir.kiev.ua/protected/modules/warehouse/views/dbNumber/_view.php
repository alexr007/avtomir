<?php
/* @var $this DbNumbersController */
/* @var $data DbNumbers */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('n_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->n_id), array('view', 'id'=>$data->n_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('n_number')); ?>:</b>
	<?php echo CHtml::encode($data->n_number); ?>
	<br />


</div>