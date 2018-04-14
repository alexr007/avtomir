<?php
	$itemsProvider = new CArrayDataProvider($data ,[
			'keyField'   => 'number', 
			'pagination' => false,
			]
		);

	$this->widget('zii.widgets.grid.CGridView', [
                'dataProvider' => $itemsProvider
        ]);
