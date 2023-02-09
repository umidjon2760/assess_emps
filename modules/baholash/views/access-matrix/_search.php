<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\baholash\models\AccessMatrixSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="access-matrix-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'TYPE') ?>

    <?= $form->field($model, 'VALUE') ?>

    <?= $form->field($model, 'MODUL') ?>

    <?= $form->field($model, 'IS_EXCEPTION') ?>

    <?php // echo $form->field($model, 'START_DATE') ?>

    <?php // echo $form->field($model, 'END_DATE') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
