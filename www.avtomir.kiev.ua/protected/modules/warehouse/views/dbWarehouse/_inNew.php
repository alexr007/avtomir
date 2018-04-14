	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
	<?php 
		echo $form->labelEx($model,'agent');
		echo $form->dropDownList($model,'agent',
				DbCagent::listDataIncoming(['show_all'=>false,'show_empty'=>true]),
				['style'=>'width:173px']);
		echo $form->error($model,'agent');
	?>
	</div>

	<div class="row">
	<?php 
		echo $form->labelEx($model,'vendor');
		echo $form->dropDownList($model,'vendor',
				DbVendor::listData(['show_all'=>false,'show_empty'=>true]),
				['style'=>'width:173px']);
		echo $form->error($model,'vendor');
	?>
	</div>
	
	<div class="row">
	<?php 
		echo $form->labelEx($model,'number');
		echo $form->textField($model,'number');
		echo $form->error($model,'number');
	?>
	</div>

	<div class="row">
	<?php 
		echo $form->labelEx($model,'qty');
		echo $form->textField($model,'qty');
		echo $form->error($model,'qty');
	?>
	</div>

	<div class="row">
	<?php 
		echo $form->labelEx($model,'price');
		echo $form->textField($model,'price');
		echo $form->error($model,'price');
	?>
	</div>
	
	<div class="row">
	<?php 
		echo $form->labelEx($model,'weight');
		echo $form->textField($model,'weight');
		echo $form->error($model,'weight');
	?>
	</div>
