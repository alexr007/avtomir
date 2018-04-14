<?php
	$form=$controller->beginWidget('CActiveForm', [
	]); 

	echo $form->textArea($priceForm,'number',
			['style'=>'width: 200px',
			'rows'=>$cleanedNumbers->count < 5 ? $cleanedNumbers->count : 5,
			'value'=>$cleanedNumbers->toText(),
			]
		);
?>

<div class="row buttons">
	<?php
		echo CHtml::button('Price ?',
				['submit'=>['index'],
				'id'=>'buttonSearch'
				]
			);
	?>
</div>

<?php
	$controller->widget('zii.widgets.grid.CGridView', [
		//'id'=>'user-trackings-grid',
		'dataProvider'=>$dbPartsPrice->searchBySession(new RuntimeSession()),
		//'filter'=>$dbPartsPrice,
		//'showTableOnEmpty'=>false,
		//'emptyText'=>'no part numbers found',
		'columns'=>[
			['name'=>'dealerS',
			'header'=>'Dealer',
			'htmlOptions'=>['width'=>'65px'], 
			'cssClassExpression'=>'$data->getFlagCss()',
			],
			'pp_vendor',
			'pp_number',
			'pp_replacenumber',
			'pp_desc_en',
			'pp_desc_ru',
			'pp_depot',
			[	'name'=>'pp_qty',
				'htmlOptions'=>['class' => 'tar'],
			],
			[	'name'=>'pp_price',
				'htmlOptions'=>['class' => 'tar'],
			],
			[	'name'=>'pp_weight',
				'htmlOptions'=>['class' => 'tar'],
			],
			[	'name'=>'pp_volume',
				'htmlOptions'=>['class' => 'tar'],
			],
			[
				'header'=>'to Cart',
				'type'=>'raw',
				'value'=>'CHtml::textField("DbPartPrice[$data->pp_id][pp_cnt]","",["style"=>"width:45px"])',
				'htmlOptions'=>['width'=>'49px'], 
			],
			[
				'header'=>'Delivery',
				'type'=>'raw',
				'value'=>'CHtml::dropDownList("DbPartPrice[$data->pp_id][pp_dtype]", null, DbDeliveryType::listData(["show_all"=>false,"show_empty"=>true]))',
				'htmlOptions'=>['width'=>'55px'], 
			],
		],
	]); 
	
	echo CHtml::button('Add To Cart',
			['submit'=>['toCart'],
			'id'=>'buttonAddToCart']
		);
	
	$controller->endWidget();
	