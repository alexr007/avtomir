<?php

class SimpleSqlDbGrid {
	
	public function __construct($controller, $sql, $key)
	{
		$controller->widget('zii.widgets.grid.CGridView', [
			'dataProvider'=>(new SqlDataProvider($sql,$key))->provider(),
			]
	);
		
	}
}
