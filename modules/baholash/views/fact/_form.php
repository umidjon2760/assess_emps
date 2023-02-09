<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\baholash\models\RelationGroup;
use app\modules\baholash\models\Pokaz;
use app\modules\baholash\models\Period;

$groups = RelationGroup::getAll();
$pokazs = Pokaz::getall();
$periods = Period::getAllPeriods();
?>

<div class="fact-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'GROUP_CODE')->dropDownList([''=>'Танланг...']+$groups) ?>

    <?= $form->field($model, 'LOV_ID')->textInput() ?>

    <?= $form->field($model, 'NUV_ID')->textInput() ?>

    <?= $form->field($model, 'POKAZ_CODE')->dropDownList([''=>'Танланг...']+$pokazs) ?>

    <?= $form->field($model, 'VALUE')->textInput() ?>

    <?= $form->field($model, 'COMMENT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PERIOD')->dropDownList([''=>'Танланг...']+$periods,['value'=>Period::getPeriod()]) ?>

    <div class="form-group">
        <?= Html::submitButton('Саклаш', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
