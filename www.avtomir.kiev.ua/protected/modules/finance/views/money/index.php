<?php
/* @var $this MoneyController */

$this->breadcrumbs=array(
	'Money',
);
?>
<h2>money/index</h2>

<?php
    echo CHtml::button('Add Money',
        ['submit'=>['money/add']
        ]
    );
