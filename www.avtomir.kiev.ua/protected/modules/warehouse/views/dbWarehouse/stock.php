<h2>Warehouse</h2>
<?php
	
	$this->widget('zii.widgets.grid.CGridView', [
			'dataProvider'=>$stock->search(),
			'filter'=>$stock,
			'columns'=>[
					['name'=>'v_name',
					'footer'=>"Total:",
						],
					['name'=>'n_number',
					'footer'=>$stat->getTotalUniqueNumbers(),
						],
					['name'=>'sum',
					'footer'=>$stat->getTotalItems(),
						],
					['name'=>'in_price',
					'footer'=>$stat->getTotalMoney(),
						],
				],
		]
	);
	
				
