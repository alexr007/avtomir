<?php
    //$this->pageTitle = "all1";

	$incomingAll = new DbIncomingAll();

	$this->widget('zii.widgets.grid.CGridView', [
			'dataProvider'=>$incomingAll->search(),
			'columns'=>[
				'inDateS',//'in_date',
				//'in_cagent',
				'ca_name',
				//'pn_id',
				'v_name',
				'n_number',
				'in_qty',
				'in_price',
				'in_weight',	
				[
					'class'=>'CButtonColumn',
					'template'=> '{update} {delete}',
					'buttons'=>[
						'update'=>[
							'url'=>'Yii::app()->createUrl("warehouse/dbWarehouse/inEdit", ["id"=>$data->in_id])',
						],
						'delete'=>[
							'url'=>'Yii::app()->createUrl("warehouse/dbWarehouse/inDelete", ["id"=>$data->in_id])',
						],
					],
				],
			],
		]
	);

	echo CHtml::button('Add New In',['submit'=>'inNew']);

	
	