<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\baholash\models\Filials */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="filials-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'MFO')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'LOCAL_CODE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'NAME')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Саклаш', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
