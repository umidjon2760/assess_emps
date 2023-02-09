<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\baholash\models\KpiCard */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="kpi-card-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'PERIOD')->textInput() ?>

    <?= $form->field($model, 'INPS')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MFO')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'LOCAL_CODE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CODE_DOLJ')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'KPI_METHOD')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'TABNUM')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ORD')->textInput() ?>

    <?= $form->field($model, 'CRITERIY_NAME')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CRITERIY_ALGORITHM')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MIN_VALUE')->textInput() ?>

    <?= $form->field($model, 'AVG_VALUE')->textInput() ?>

    <?= $form->field($model, 'MAX_VALUE')->textInput() ?>

    <?= $form->field($model, 'VES')->textInput() ?>

    <?= $form->field($model, 'PLAN')->textInput() ?>

    <?= $form->field($model, 'FACT')->textInput() ?>

    <?= $form->field($model, 'BAJARILISH')->textInput() ?>

    <?= $form->field($model, 'IVSH')->textInput() ?>

    <?= $form->field($model, 'CRITERIY_KPI')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Саклаш', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
