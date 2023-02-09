<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\baholash\models\ZagrSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="zagr-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'CBID') ?>

    <?= $form->field($model, 'INPS') ?>

    <?= $form->field($model, 'MFO') ?>

    <?= $form->field($model, 'LOCAL_CODE') ?>

    <?php // echo $form->field($model, 'NAME') ?>

    <?php // echo $form->field($model, 'BOLIM_CODE') ?>

    <?php // echo $form->field($model, 'BOLIM_NAME') ?>

    <?php // echo $form->field($model, 'CODE_DOLJ') ?>

    <?php // echo $form->field($model, 'LAVOZIM_NAME') ?>

    <?php // echo $form->field($model, 'TABEL') ?>

    <?php // echo $form->field($model, 'PERIOD') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
