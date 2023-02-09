<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
/* @var $this yii\web\View */
/* @var $model app\models\Users */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'MFO')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'NAME')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'BOLIM_NAME')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CODE_DOLJ')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'EMAIL')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'LAVOZIM_NAME')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PHONE_NUMBER')->widget(MaskedInput::classname(),[
                    'name' => 'mobil',
                    'mask' => '999999999',
                    'value'=>$model->PHONE_NUMBER,
                    'options'=>['required'=>true,'class'=>'form-control','id'=>'phone',]
                ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Саклаш', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
