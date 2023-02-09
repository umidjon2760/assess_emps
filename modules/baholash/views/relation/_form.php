<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\modules\baholash\models\RelationGroup;
/* @var $this yii\web\View */
/* @var $model app\modules\baholash\models\Relation */
/* @var $form yii\widgets\ActiveForm */
$groups = RelationGroup::getAll();
?>

<div class="relation-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'GROUP_CODE')->widget(Select2::classname(), [
                'data' => $groups,
                'options' => ['prompt' => 'Гурух танланг ...','multiple'=>false],
                'pluginOptions' => [
                    'allowClear' => true
                ],
                'theme' => Select2::THEME_BOOTSTRAP,
                // 'theme' => \kartik\select2\Select2::THEME_MATERIAL,
            ]) ?>

    <?= $form->field($model, 'NUV_DOLJ_CODE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'LOV_DOLJ_CODE1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'LOV_DOLJ_CODE2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'LOV_DOLJ_CODE3')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Саклаш', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
