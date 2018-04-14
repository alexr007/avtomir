<h2>Warehouse carts list:</h2>
<?php
	
	$this->widget('zii.widgets.grid.CGridView', [
		'dataProvider'=>$dataProvider,
		//'filter'=>$dbPartsPrice,
		//'showTableOnEmpty'=>false,
		//'emptyText'=>'no part numbers found',
		
		'columns'=>[
			'dateS',
			'ca_name',
			'cart_cnt',
			'cart_qty',
			[
				'class'=>'CButtonColumn',
				'template'=>'{view}',
				'buttons'=>[
					'view'=>[
						//'imageUrl'=>Yii::app()->assetManager->baseUrl.'/icons/excel.png',
//						'url'=>'Yii::app()->createUrl("warehouse/dbCart/view", ["id"=>$data->ca_id])',
						'url'=>'Yii::app()->createUrl("warehouse/dbCart/view/id/$data->ca_id")',
						//'urlExpression'=>'"excel?pallet=".$data->id',
						//'click'=>"js:$js_excel",
					],
				],
			],
		],
	]); 
