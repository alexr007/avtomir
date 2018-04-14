<?php

	$outgoingAll = new DbOutgoingAll();

	$this->widget('zii.widgets.grid.CGridView', [
			'dataProvider'=>$outgoingAll->search(),
		]
	);

	echo CHtml::button('Add New Out',['submit'=>'outNew']);
