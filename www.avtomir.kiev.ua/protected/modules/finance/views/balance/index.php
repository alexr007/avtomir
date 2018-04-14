<?php
/* @var $this MoneyController */

$this->breadcrumbs=array(
	'Money',
);
?>
<h2>balance/index</h2>

<p>
    <?php
    $moneyColumnProperties=['width'=>'70px','class'=>'tar'];

    $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'db-balance-grid',
        'dataProvider'=>$model->search(),
        'filter'=>$model,
        'columns'=>array(
            /*
                [
                'name'=>'agentId',
                'header'=>'Agent id',
            ],
            */
            [
                'name'=>'name',
                'value'=>'$data->agentName',
                'header'=>'Agent Name',
            ],
            [
                'name'=>'BalanceCurrentS',
                'header'=>'Current Balance',
                'htmlOptions'=>$moneyColumnProperties,
                'footer'=>$stat->getBalanceCurrentS(),
            ],
            [
                'name'=>'amountReadyS',
                'header'=>'Ready to Ship',
                'htmlOptions'=>$moneyColumnProperties,
                'footer'=>$stat->getAmountReadyS(),
            ],
            [
                'name'=>'amountWorkS',
                'header'=>'In Working',
                'htmlOptions'=>$moneyColumnProperties,
                'footer'=>$stat->getAmountWorkS(),
            ],
            [
                'name'=>'amountNewS',
                'header'=>'New',
                'htmlOptions'=>$moneyColumnProperties,
                'footer'=>$stat->getAmountNewS(),
            ],
            [
                'name'=>'balanceTotalS',
                'header'=>'Balance Total',
                'htmlOptions'=>$moneyColumnProperties,
                'footer'=>$stat->getBalanceTotalS(),
            ],
            /*
            array(
                'class'=>'CButtonColumn',
            ),
            */
        ),
    ));

    ?>
</p>
