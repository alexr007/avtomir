<?php

// список всех заказов
	$this->widget('zii.widgets.grid.CGridView', [
		'dataProvider'=>$dataProvider,
		//'filter'=>$dbPartsPrice,
		//'showTableOnEmpty'=>false,
		//'emptyText'=>'no part numbers found',
		
		'columns'=>[
			'wo_orderid',
			'ca_name',
			'total_numbers',
			'total_items',
			'total_amount',
			[
				'class'=>'CButtonColumn',
				'template'=>'{view}',
				'buttons'=>[
					'view'=>[
						//'imageUrl'=>Yii::app()->assetManager->baseUrl.'/icons/excel.png',
//						'url'=>'Yii::app()->createUrl("warehouse/dbCart/view", ["id"=>$data->ca_id])',
						'url'=>'Yii::app()->createUrl("warehouse/dbOrder/view/id/$data->wo_orderid")',
						//'urlExpression'=>'"excel?pallet=".$data->id',
						//'click'=>"js:$js_excel",
					],
				],
			],
		],
	]); 
