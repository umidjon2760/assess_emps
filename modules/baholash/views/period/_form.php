<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model app\modules\baholash\models\Period */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="period-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'PERIOD')->widget(\kartik\widgets\DatePicker::classname(),[
                                                    'options'=>[
                                                        'required'=>'required',
                                                        "readonly"=>'true'
                                                    ],
                                                    'pluginOptions'=>[
                                                        'todayHighlight'=>true,
                                                        'autoclose'=>true,
                                                        'required'=>'required',
                                                        'format'=>'yyyy-mm-dd',
                                                    ],
                                                    
                                                ]) ?>

    <?= $form->field($model, 'IS_OPEN')->dropDownList([''=>'Танланг...','0'=>'Ёпиқ','1'=>'Очиқ']) ?>

    <div class="form-group">
        <?= Html::submitButton('Саклаш', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
