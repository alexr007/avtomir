<?php

Yii::app()->getClientScript()->registerScript('scripts_begin', "

function show_message(div, msg_type, msg_text) {
	var html = '<div class=\"flash-'+msg_type+'\">'+msg_text+'</div>';
	
	if (msg_type=='error') 
		$(div).html(html).fadeIn(100);
	else 
		$(div).html(html).fadeIn(100).fadeOut(1500);
}

function before_save() {
	$('#btnSave').prop('disabled', true);
}

function clear_fields() {
	$('#FormIncoming_number').val('');
	$('#FormIncoming_qty').val('');
	$('#FormIncoming_price').val('');
	$('#FormIncoming_weight').val('');
}

function focus_field() {
	$('#FormIncoming_number').focus();
}

function after_save(data) {
	clear_fields();
	show_message('#result', 'success', data);
	$('#btnSave').prop('disabled', false);
	focus_field();
}

function save() {
	$.ajax({
		type: 'POST',
		url: 'inNewSave',
		data: $('#form-new-in').serialize(),
		dataType: 'html',
		success: function(data){ 
					after_save(data);
				}
	});
}

function btn_save() {
	before_save();
	save();
	return false;
}

", CClientScript::POS_BEGIN);

?>

<div class="form">

<?php 
	$form=$this->beginWidget('CActiveForm', [
		'id'=>'form-new-in',
	]);
	
	$this->renderPartial('_inNew', [
				'form'=>$form,
				'model'=>$model,
			]);
?>

	<div class="row buttons">
<?php
		echo CHtml::button('Create',
			['id'=>'btnSave',
			'onclick'=>'js:btn_save();']
		);
?>
	</div>
	
	<div id="result">
	</div>

<?php 
	$this->endWidget();
?>

</div><!-- form -->
<div id="result">
</div>