<?php

	$this->widget('zii.widgets.grid.CGridView', [
		//'id'=>'user-trackings-grid',
		'dataProvider'=>$dataProvider,
		//'filter'=>$dbPartsPrice,
		//'showTableOnEmpty'=>false,
		//'emptyText'=>'no part numbers found',
		
		'columns'=>[
			'in_pn',
			'v_name',
			'n_number',
			'sum',
			'in_price',
			[
				'header'=>'Qty',
				'type'=>'raw',
				'value'=>'CHtml::textField("FormOutgoing[selection][$data->in_link][pp_qty]","",["style"=>"width:45px"])',
				'htmlOptions'=>['width'=>'49px'], 
			],
		],
	]); 
	
//	echo CHtml::button('to Cart',['submit'=>'outNewSave','id'=>'idToCart']);

	