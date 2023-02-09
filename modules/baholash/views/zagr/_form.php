<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\baholash\models\Zagr */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="zagr-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'CBID')->textInput() ?>

    <?= $form->field($model, 'INPS')->textInput() ?>

    <?= $form->field($model, 'MFO')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'LOCAL_CODE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'NAME')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'BOLIM_CODE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'BOLIM_NAME')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CODE_DOLJ')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'LAVOZIM_NAME')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'TABEL')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PERIOD')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Саклаш', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
