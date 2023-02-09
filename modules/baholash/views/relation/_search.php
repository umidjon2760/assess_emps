<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\baholash\models\RelationSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="relation-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'GROUP_CODE') ?>

    <?= $form->field($model, 'NUV_DOLJ_CODE') ?>

    <?= $form->field($model, 'LOV_DOLJ_CODE1') ?>

    <?= $form->field($model, 'LOV_DOLJ_CODE2') ?>

    <?php // echo $form->field($model, 'LOV_DOLJ_CODE3') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
