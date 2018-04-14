<?php
?>

<div class="form">

<?php 
	$form=$this->beginWidget('CActiveForm', [
		'id'=>'out_new-form',
		'focus'=>[$outgoing,'number'],
	]);
?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($outgoing); ?>

	<div class="row">
	<?php 
		echo $form->labelEx($outgoing,'agent');
		echo $form->dropDownList($outgoing,'agent',
				DbCagent::listDataOutgoing(['show_all'=>false,'show_empty'=>true]),
				['style'=>'width:173px']);
		echo $form->error($outgoing,'agent');
	?>
	</div>
	
	<div class="row">
	<?php 
		echo $form->labelEx($outgoing,'number');
		echo $form->textField($outgoing,'number');
		echo $form->error($outgoing,'number');
	?>
	</div>
	
	<div class="row buttons">
	<?php
		echo CHtml::ajaxButton('Search', ['outNewItems'], // action
				[	'data'=>'js:($("#out_new-form").serialize())',
					'type'=>'POST',
					'success' =>
						'function(data){
							$("#grid_selection").html(data);
						}',
				],
			[]
		);
	?>
	</div>
	
	<div id="grid_selection">
	</div>	
	<div class="row buttons">
	<?php
		echo CHtml::submitButton('to Cart',['submit'=>'outNewSave','id'=>'idToCart']);
	?>
	</div>	
<?php 
	$this->endWidget();
?>

</div><!-- form -->
<div id="result">
</div>