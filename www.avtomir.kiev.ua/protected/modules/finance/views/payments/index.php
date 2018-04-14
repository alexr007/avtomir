<?php
/* @var $this MmmController */
/* @var $model DbMoney */

$this->breadcrumbs=array(
	'Db Moneys'=>array('index'),
	'Manage',
);

$this->menu=array(
);

?>

<h2>Payments</h2>

<?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'db-money-grid',
        'dataProvider'=>$model->search(),
        'filter'=>$model,
        'columns'=>array(
            //'mo_id',
            'date',
            //'mo_cagent',
            [   'name'=>'cagentS',
                'filter'=>CHtml::dropDownList(
                    'DbMoney[mo_cagent]',
                    $model->mo_cagent,
                    $cagents::listData()
                ),
            ],
            [
                'name'=>'amountUSD',
                'filter'=>CHtml::textField(
                    'DbMoney[mo_amount]',
                    $model->amountUSD
                ),

                'htmlOptions'=>['class' => 'tar'],
            ],
            'mo_comment',
            /*
            array(
                'class'=>'CButtonColumn',
            ),
            */
        ),
    ));
?>
