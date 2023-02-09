<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\baholash\models\Session */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="session-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'LOV_ID')->textInput() ?>

    <?= $form->field($model, 'GROUP_CODE')->textInput() ?>

    <?= $form->field($model, 'MFO')->textInput() ?>

    <?= $form->field($model, 'SESSION_ID')->dropDownList([''=>'Танланг...','1'=>'Очиқ','2'=>'Ёпиқ']) ?>

    <?= $form->field($model, 'PERIOD')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Саклаш', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
