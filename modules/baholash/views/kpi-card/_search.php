<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\baholash\models\KpiCardSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="kpi-card-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'PERIOD') ?>

    <?= $form->field($model, 'INPS') ?>

    <?= $form->field($model, 'MFO') ?>

    <?= $form->field($model, 'LOCAL_CODE') ?>

    <?php // echo $form->field($model, 'CODE_DOLJ') ?>

    <?php // echo $form->field($model, 'KPI_METHOD') ?>

    <?php // echo $form->field($model, 'TABNUM') ?>

    <?php // echo $form->field($model, 'ORD') ?>

    <?php // echo $form->field($model, 'CRITERIY_NAME') ?>

    <?php // echo $form->field($model, 'CRITERIY_ALGORITHM') ?>

    <?php // echo $form->field($model, 'MIN_VALUE') ?>

    <?php // echo $form->field($model, 'AVG_VALUE') ?>

    <?php // echo $form->field($model, 'MAX_VALUE') ?>

    <?php // echo $form->field($model, 'VES') ?>

    <?php // echo $form->field($model, 'PLAN') ?>

    <?php // echo $form->field($model, 'FACT') ?>

    <?php // echo $form->field($model, 'BAJARILISH') ?>

    <?php // echo $form->field($model, 'IVSH') ?>

    <?php // echo $form->field($model, 'CRITERIY_KPI') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
