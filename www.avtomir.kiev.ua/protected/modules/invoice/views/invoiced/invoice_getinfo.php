<?php
/**
 * Created by PhpStorm.
 * User: alexr
 * Date: 07.03.2017
 * Time: 12:22
 */
	$this->breadcrumbs=[];
	$this->menu=[];
?>

<h2>Incoming Invoice parse</h2>

<div class="form">
<?php
	$form = $this->beginWidget('CActiveForm',[
        'id' => 'invoice-parse-form',
        'enableAjaxValidation' => false,
        /*				'clientOptions'=>[
                            'validateOnChange'=>true,
                            'validateOnSubmit' => true,
                        ],
        'htmlOptions' => ['enctype' => 'multipart/form-data'],
        */
    ]);
	?>

    <div class="row">
    <?php
        echo $form->labelEx($model,'date');
        //echo $form->textField($model,'date');
        $this->widget('zii.widgets.jui.CJuiDatePicker',array(
            'name'=>get_class($model).'[date]',
            //'id'=>'Modelname_datecolumn name',
          //'value'=>Yii::app()->dateFormatter->format("dd.mm.yyyy",strtotime($model->date)),
            'options'=>[
                'dateFormat'=>'yy-mm-dd',
            //    'showAnim'=>'fold',
            ],
            'htmlOptions'=>[
                'style'=>'height:20px;'
            ],
    ));         echo $form->error($model,'date');
     ?>
    </div>
    <div class="row">
        <?php
        echo $form->labelEx($model,'dealer');
        echo $form->dropDownList($model,'dealer',
            $dealers::listData(['show_all'=>false,'show_empty'=>true]),
            ['style'=>'width:173px']);
        echo $form->error($model,'dealer');
        ?>
    </div>
    <div class="row">
        <?php
        echo $form->labelEx($model,'invoice');
        echo $form->textField($model,'invoice');
        echo $form->error($model,'invoice');
        ?>
    </div>
    <div class="row">
        <?php
        echo $form->labelEx($model,'method');
        echo $form->dropDownList($model,'method',
            $methods::listData(['show_all'=>false,'show_empty'=>true]),
            ['style'=>'width:173px']);
        echo $form->error($model,'method');
        ?>
    </div>
    <div class="row">
        <?php
        echo $form->labelEx($model,'details');
        echo $form->textArea($model,'details', [
            'style'=>'width: 400px',
             'rows'=>20,
             'value'=>"",
            ]
            );
        echo $form->error($model,'details');
        ?>
    </div>

<?php
	echo CHtml::submitButton('Parse');

	$this->endWidget();
?>
</div>
