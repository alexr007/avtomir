<?php
/* @var $this DbVendorsController */
/* @var $data DbVendors */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('v_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->v_id), array('view', 'id'=>$data->v_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('v_name')); ?>:</b>
	<?php echo CHtml::encode($data->v_name); ?>
	<br />


</div>