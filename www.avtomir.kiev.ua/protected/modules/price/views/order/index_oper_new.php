<h2>All orders New Items (operator screen)</h2>
<?php

    $form=$this->beginWidget('CActiveForm', [
    ]);

    $this->widget('zii.widgets.grid.CGridView', [
            'dataProvider'=> $dataProvider,
            'columns'=>[
                [
                    'header'=>'Order Number',
                    'name'=>'oiOrder.o_number',
                ],
                [
                    'header'=>'Cagent',
                    'name'=>'oiOrder.oCagent.ca_name',
                ],
                [
                    'header'=>'ShipMethod',
                    'name'=>'oiShipMethod.dt_name',
                ],
                [
                    'header'=>'Dealer',
                    'name'=>'oiDealer.dl_name',
                ],
                [
                    'header'=>'Vendor',
                    'name'=>'oi_vendor',
                ],
                [
                    'header'=>'Parn Number',
                    'name'=>'oi_number',
                ],
                [
                    'header'=>'Qty',
                    'name'=>'oi_qty',
                ],
                [
                    'header'=>'Price 1 pcs',
                    'name'=>'oi_price',
                ],
                [
                    'header'=>'Description EN',
                    'name'=>'oi_desc_en',
                ],
                [
                    'header'=>'Description RU',
                    'name'=>'oi_desc_ru',
                ],
            ], // columns
        ]); // grid

    echo CHtml::button('Excel',
        ['submit'=>['ExportExcelNewItems'],
            'id'=>'buttonExportExcelNewItems']
    );

    $this->endWidget();

