<?php
/* @var $this CountryController */
/* @var $data DbCountry */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('co_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->co_id), array('view', 'id'=>$data->co_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('co_name')); ?>:</b>
	<?php echo CHtml::encode($data->co_name); ?>
	<br />


</div>