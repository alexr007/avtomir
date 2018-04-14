<h2>All orders (operator screen)</h2>
<?php

    $form=$this->beginWidget('CActiveForm', [
    ]);

    $this->widget('zii.widgets.grid.CGridView', [
            'dataProvider'=> $dataProvider,
            'columns'=>[
                //'o_id',
                'o_number',
                [	'header'=>'User',
                    'type'=>'raw',
                    'value'=>'$data->cagentS',
                ],
                [	'header'=>'Status',
                    'type'=>'raw',
                    'value'=>'$data->statusS',
                ],
                /*
                [
                    'header'=>'Status',
                    'type'=>'raw',
                    'value'=>'CHtml::dropDownList("DbOrder[$data->o_id][o_status]", $data->o_status, DbOrderStatus::listData(["show_all"=>false,"show_empty"=>false]))',
                    //'value'=>'CHtml::textField("UserProfile[$data->up_id][up_value]",$data->fieldValue,["style"=>"width:45px"])',
                    'htmlOptions'=>['width'=>'55px'],
                ],
                 */
                'o_comment_user',
                'o_comment_operator',
                [	'header'=>'Date In',
                    'type'=>'raw',
                    'value'=>'$data->dateInS',
                    'htmlOptions'=>['class' => 'tac',
                                    'width'=>'100px'],
                ],
                /*
                [	'header'=>'Date Process',
                    'type'=>'raw',
                    'value'=>'$data->dateProcessS',
                    'htmlOptions'=>['class' => 'tac',
                                    'width'=>'100px'],
                ],
                [	'header'=>'Date Close',
                    'type'=>'raw',
                    'value'=>'$data->dateCloseS',
                    'htmlOptions'=>['class' => 'tac',
                                    'width'=>'100px'],
                ],
                */
                [	'header'=>'lines',
                    'value'=>'$data->getTotalUniqueNumbers()',
                    'htmlOptions'=>['class' => 'tac'],
                ],
                [	'header'=>'items',
                    'value'=>'$data->getTotalItems()',
                    'htmlOptions'=>['class' => 'tac'],
                ],
                [	'header'=>'total',
                    'value'=>'$data->getTotalMoney()',
                    'htmlOptions'=>['class' => 'tar',
                                    'width'=>'50px'],
                ],
                [
                    'class'=>'CButtonColumn',
                    'template'=> '{view} {update} {delete} {excel}',
                    'buttons'=>[
                        // редактирование заказа
                        'update'=>[
                            //'url'=>'Yii::app()->createUrl("price/order/edit", ["id"=>$data->id])',
                            'url'=>'Yii::app()->createUrl("price/order/edit/id/$data->id")',
                        ],
                        // удаление заказа
                        'delete'=>[
                            'url'=>'Yii::app()->createUrl("price/order/orderDeleteItem", ["id"=>$data->id])',
                        ],
                        'excel'=>[
                            'imageUrl'=>Yii::app()->assetManager->baseUrl.'/icons/excel.png',
                            //'url'=>'Yii::app()->createUrl("price/order/toExcel", ["id"=>$data->id])',
                            'url'=>'Yii::app()->createUrl("price/order/toExcel/id/$data->id")',
                        ],
                    ],
                    'htmlOptions' => ['style'=>'width:85px'],
                ],
            ], // columns
        ]); // grid

    echo CHtml::button('Submit',
        ['submit'=>['submitChanges'],
            'id'=>'buttonSubmitChanges']
    );
    echo " ";

    echo CHtml::button('All Order Items',
        ['submit'=>['NewItems'],
            'id'=>'buttonNewItems']
    );

    $this->endWidget();

