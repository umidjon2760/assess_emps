<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\baholash\models\AccessMatrix;
/* @var $this yii\web\View */
/* @var $model app\modules\baholash\models\AccessMatrix */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="access-matrix-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'TYPE')->dropDownList(AccessMatrix::getDostupTypes()) ?>

    <?= $form->field($model, 'VALUE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MODUL')->dropDownList(AccessMatrix::getModules()) ?>

    <?= $form->field($model, 'IS_EXCEPTION')->dropDownList(['0'=>'0','1'=>'1']) ?>

    <?= $form->field($model, 'START_DATE')->textInput(['type'=>'date']) ?>

    <?= $form->field($model, 'END_DATE')->textInput(['type'=>'date']) ?>

    <div class="form-group">
        <?= Html::submitButton('Саклаш', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
