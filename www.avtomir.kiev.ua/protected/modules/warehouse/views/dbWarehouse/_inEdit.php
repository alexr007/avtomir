<?php
	$ro=['readonly'=>true];
	$roDD=['disabled'=>'disabled'];

?>
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
	<?php 
		echo $form->labelEx($model,'in_cagent');
		echo $form->dropDownList($model,'in_cagent',
				DbCagent::listDataIncoming(['show_all'=>false,'show_empty'=>true]),
				['style'=>'width:173px']+$roDD);
		echo $form->error($model,'in_cagent');
	?>
	</div>

	<div class="row">
	<?php 
		echo $form->labelEx($model,'fullNameS');
		echo $form->textField($model,'fullNameS',$ro);
		echo $form->error($model,'fullNameS');
	?>
	</div>

	<div class="row">
	<?php 
		echo $form->labelEx($model,'in_qty');
		echo $form->textField($model,'in_qty');
		echo $form->error($model,'in_qty');
	?>
	</div>

	<div class="row">
	<?php 
		echo $form->labelEx($model,'in_price');
		echo $form->textField($model,'in_price');
		echo $form->error($model,'in_price');
	?>
	</div>
	
	<div class="row">
	<?php 
		echo $form->labelEx($model,'in_weight');
		echo $form->textField($model,'in_weight');
		echo $form->error($model,'in_weight');
	?>
	</div>
