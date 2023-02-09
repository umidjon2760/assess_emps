<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\baholash\models\FactSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="fact-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'LOV_ID') ?>

    <?= $form->field($model, 'NUV_ID') ?>

    <?= $form->field($model, 'POKAZ_CODE') ?>

    <?= $form->field($model, 'VALUE') ?>

    <?php // echo $form->field($model, 'COMMENT') ?>

    <?php // echo $form->field($model, 'PERIOD') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
