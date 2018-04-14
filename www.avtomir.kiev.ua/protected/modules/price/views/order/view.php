<?php

	$form=$this->beginWidget('CActiveForm', [
	]); 

	$this->widget('zii.widgets.grid.CGridView', [
		'dataProvider'=>$user->isOperator() 
			/*
							? $orderItems->byId($order_id)->search()
							: $orderItems->byUser($user)->byId($order_id)->search(),
			 */
							? $orderItems->search(
									(new DbOrderItemCriteria())->byId($order_id)
								)
							: $orderItems->search([
									(new DbOrderItemCriteria())->byCagent($user),
									(new DbOrderItemCriteria())->byId($order_id),
								]),
		'columns'=>[
			//'oi_id', 
			[	'header'=>'order #', 
				'type'=>'raw',
				'value'=>'$data->orderS',
				'htmlOptions'=>['class' => 'tac',
								'width'=>'50px'],
			],
			[	'header'=>'Status', 
				'type'=>'raw',
				'value'=>'$data->statusS',
				'htmlOptions'=>['class' => 'tac',
								'width'=>'50px'],
			],
			[	'header'=>'Metdod', 
				'type'=>'raw',
				'value'=>'$data->methodS',
				'htmlOptions'=>['class' => 'tac',
								'width'=>'50px'],
			],
			[	'header'=>'Dealer', 
				'type'=>'raw',
				'value'=>'$data->dealerNameS',
				'htmlOptions'=>['class' => 'tac',
								'width'=>'50px'],
			],
			[	'name'=>'oi_vendor', 
				'footer'=>"Total:",
			],
			[	'name'=>'oi_number',
				'type' => "raw",
				'value' => 'CHtml::link($data->oi_number,Yii::app()->createUrl("price/priced/index").$data->getCheckPriceUrl())',
				'footer'=>$stat == null ? 0 : $stat->getTotalUniqueNumbers(),
			],
			'oi_desc_en', 
			'oi_desc_ru', 
			'oi_depot', 
			[
				'name'=>'oi_qty', 
				'footer'=>$stat == null ? 0 : $stat->getTotalItems(),
			],	
			[	'name'=>'oi_price',
				'header'=>'price, $', 
				'htmlOptions'=>['class' => 'tar'],
				'footer'=>$stat == null ? 0 : $stat->getTotalMoney(),
			], 
			[	'name'=>'oi_weight',
				'header'=>'weight, kg', 
				'htmlOptions'=>['class' => 'tar'],
			], 
			[	'name'=>'oi_volume',
				'header'=>'m3, kg', 
				'htmlOptions'=>['class' => 'tar'],
			], 
			'oi_comment_user', 
			'oi_comment_oper',
            [	'name'=>'invoiceS',
                'header'=>'Invoice#',
            ],
            /*
            [	'header'=>'Date Process',
                'type'=>'raw',
                'value'=>'$data->dateProcessS',
                'htmlOptions'=>['class' => 'tac',
                                'width'=>'90px'],
            ],
            [	'header'=>'Date Dealer',
                'type'=>'raw',
                'value'=>'$data->dateDealerS',
                'htmlOptions'=>['class' => 'tac',
                                'width'=>'90px'],
            ],
            [	'header'=>'Date Received',
                'type'=>'raw',
                'value'=>'$data->dateReceivedS',
                'htmlOptions'=>['class' => 'tac',
                                'width'=>'90px'],
            ],
            [	'header'=>'Date Shipped',
                'type'=>'raw',
                'value'=>'$data->dateShippedS',
                'htmlOptions'=>['class' => 'tac',
                                'width'=>'90px'],
            ],
            */
			[
				'class'=>'CButtonColumn',
				'template'=> '{update} {delete}',
			],
		]
	]); 
	
	$this->endWidget();
