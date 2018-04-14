<h2>Warehouse cart for user id=<b><?php
	echo $cagent_id;
?></b></h2>

<?php
	$form=$this->beginWidget('CActiveForm', [
			'id'=>'toOrder',
		]);
	
	echo $form->hiddenField($toOrder, 'cagent', ['value'=>$cagent_id]);

	$this->widget('zii.widgets.grid.CGridView', [
		'dataProvider'=>$dataProvider,
		'columns'=>[
			//'wc_id',
			'dateS',
			'cagentS',
			//'wc_link',
			'partNumberS',
			'wc_qty',
			// это чекбокс чтобы потом перенести cart -> order
			[
				'header'=>'to order',
				'type'=>'raw',
				'value'=>'CHtml::CheckBox("FormToOrder[selection][$data->wc_id]","1",["style"=>"width:45px"])',
				'htmlOptions'=>['width'=>'49px'], 
			]
		],
		
	]); 

	echo CHtml::submitButton('Submit Selected to order',['submit'=>
		Yii::app()->createUrl("warehouse/dbCart/toOrder")
	]);

	$this->endWidget();
	