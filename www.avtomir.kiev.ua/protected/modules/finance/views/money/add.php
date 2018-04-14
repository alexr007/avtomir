<?php
/* @var $this MoneyController */

$this->breadcrumbs=array(
	'Money'=>array('/finance/money'),
	'AddMoney',
);
?>
<h2>add money</h2>
    <div class="form">

        <?php
            $form=$this->beginWidget('CActiveForm', array(
                'id'=>'db-money-1-form',
                'enableAjaxValidation'=>false,
            ));
        ?>

        <p class="note">Fields with <span class="required">*</span> are required.</p>

        <?php
            echo $form->errorSummary($model);
        ?>

        <div class="row">
            <?php
                echo "Select ".$form->labelEx($model,'mo_cagent');

                echo $form->dropDownList($model,'mo_cagent',
                    $cagents::listData(['show_all'=>false,'show_empty'=>true]),
                    ['style'=>'width:173px']);
                //echo $form->textField($model,'mo_cagent');

                echo $form->error($model,'mo_cagent');
            ?>
        </div>

        <div class="row">
            <?php
                echo "Enter ".$form->labelEx($model,'mo_amount');
                echo $form->textField($model,'mo_amount');
                echo $form->error($model,'mo_amount');
            ?>
        </div>

        <div class="row">
            <?php
                echo $form->labelEx($model,'mo_comment');
                echo $form->textField($model,'mo_comment');
                echo $form->error($model,'mo_comment');
            ?>
        </div>

        <div class="row buttons">
            <?php
            echo CHtml::button('Submit',
                ['submit'=>['money/addSubmit'],
                    'id'=>'buttonSubmitChanges'
                ]);
            ?>
        </div>

    <?php
        $this->endWidget();
    ?>

    </div><!-- form -->
