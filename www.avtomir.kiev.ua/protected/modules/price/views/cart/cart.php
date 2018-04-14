<?php

	$form=$this->beginWidget('CActiveForm', [
		//'id'=>'user-profile-form',
		//'enableAjaxValidation'=>false,
	]); 

	$this->widget('zii.widgets.grid.CGridView', [
		//'id'=>'user-trackings-grid',
		'dataProvider'=>$dbCart->searchByUser(new RuntimeUser()),
		//'filter'=>$dbPartsPrice,
		//'showTableOnEmpty'=>false,
		//'emptyText'=>'no part numbers found',
		'columns'=>[
			'ct_id',
			['name'=>'dealerS',
			'header'=>'Dealer',
			'htmlOptions'=>['width'=>'70px'], 
			'cssClassExpression'=>'$data->getFlagCss()',
			],
			'ct_vendor',
			'ct_number',
			'ct_desc_en',
			'ct_desc_ru',
			'ct_depot',
			'ct_price',
			'ct_quantity',
			'ct_weight',
			'ct_volume',
			'dateS',
			'ct_comment_user',
			'ct_comment_oper',
			'userS',
			'dtypeS',
			[
				'class'=>'CButtonColumn',
				'template'=> '{update} {delete}',
				//'template'=> '{view} {update} {delete}',
				'buttons'=>[
					'view'=>[
						'url'=>'Yii::app()->createUrl("price/cart/cartViewItem", ["id"=>$data->id])',
					],
					'update'=>[
						'url'=>'Yii::app()->createUrl("price/cart/cartEditItem", ["id"=>$data->id])',
					],
					'delete'=>[
						'url'=>'Yii::app()->createUrl("price/cart/cartDeleteItem", ["id"=>$data->id])',
					],
				],
			],
		]
	]); 
	
	echo CHtml::button('Add To Order',
						['submit'=>['cart/toOrder'],
						'id'=>'buttonAddToOrder']
		);
	
	$this->endWidget();
