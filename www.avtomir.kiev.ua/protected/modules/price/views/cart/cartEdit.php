<h2>cart item edit:</h2>
<?php
	/*
	 * $cartItem
	 * $this
	 * 
	 */
?>
			
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', []);
	$style = ['style'=>'width:200px'];
?>

	<div class="row">
		<?php
			echo $form->labelEx($cartItem,'ct_dealer');
			echo $form->textField($cartItem,'ct_dealer',$style);
			echo $form->error($cartItem,'ct_dealer');
		?>
	</div>
	
	<div class="row">
		<?php
			echo $form->labelEx($cartItem,'ct_vendor');
			echo $form->textField($cartItem,'ct_vendor',$style);
			echo $form->error($cartItem,'ct_vendor');
		?>
	</div>
	
	<div class="row">
		<?php
			echo $form->labelEx($cartItem,'ct_number');
			echo $form->textField($cartItem,'ct_number',$style);
			echo $form->error($cartItem,'ct_number');
		?>
	</div>
	
	<div class="row">
		<?php
			echo $form->labelEx($cartItem,'ct_desc_en');
			echo $form->textField($cartItem,'ct_desc_en',$style);
			echo $form->error($cartItem,'ct_desc_en');
		?>
	</div>
	
	<div class="row">
		<?php
			echo $form->labelEx($cartItem,'ct_desc_ru');
			echo $form->textField($cartItem,'ct_desc_ru',$style);
			echo $form->error($cartItem,'ct_desc_ru');
		?>
	</div>
	
	<div class="row">
		<?php
			echo $form->labelEx($cartItem,'ct_depot');
			echo $form->textField($cartItem,'ct_depot',$style);
			echo $form->error($cartItem,'ct_depot');
		?>
	</div>
	
	<div class="row">
		<?php
			echo $form->labelEx($cartItem,'ct_price');
			echo $form->textField($cartItem,'ct_price',$style);
			echo $form->error($cartItem,'ct_price');
		?>
	</div>
	
	<div class="row">
		<?php
			echo $form->labelEx($cartItem,'ct_quantity');
			echo $form->textField($cartItem,'ct_quantity',$style);
			echo $form->error($cartItem,'ct_quantity');
		?>
	</div>
	
	<div class="row">
		<?php
			echo $form->labelEx($cartItem,'ct_weight');
			echo $form->textField($cartItem,'ct_weight',$style);
			echo $form->error($cartItem,'ct_weight');
		?>
	</div>
	
	<div class="row">
		<?php
			echo $form->labelEx($cartItem,'ct_volume');
			echo $form->textField($cartItem,'ct_volume',$style);
			echo $form->error($cartItem,'ct_volume');
		?>
	</div>
	
	<div class="row">
		<?php
			echo $form->labelEx($cartItem,'ct_date');
			echo $form->textField($cartItem,'ct_date',$style);
			echo $form->error($cartItem,'ct_date');
		?>
	</div>
	
	<div class="row">
		<?php
			echo $form->labelEx($cartItem,'ct_comment_user');
			echo $form->textField($cartItem,'ct_comment_user',$style);
			echo $form->error($cartItem,'ct_comment_user');
		?>
	</div>
	
	<div class="row">
		<?php
			echo $form->labelEx($cartItem,'ct_comment_oper');
			echo $form->textField($cartItem,'ct_comment_oper',$style);
			echo $form->error($cartItem,'ct_comment_oper');
		?>
	</div>
	
	<div class="row">
		<?php
			echo $form->labelEx($cartItem,'ct_dtype');
			echo $form->dropDownList($cartItem,'ct_dtype',
					DbDeliveryType::listData(['show_all'=>false]),
					$style
				);
			echo $form->error($cartItem,'ct_dtype');
		?>
	</div>

	<div class="row buttons">
		<?php 
			echo CHtml::submitButton($cartItem->isNewRecord ? 'Create' : 'Save');
		?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->