<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\baholash\models\Relation;
use app\modules\baholash\models\Pokaz;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model app\modules\baholash\models\RelPokaz */
/* @var $form yii\widgets\ActiveForm */
$rels = Relation::getAllRelationID();
$pokazs = Pokaz::getAllWithPokaz();
?>

<div class="rel-pokaz-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'REL_ID')->widget(Select2::classname(), [
                'data' => $rels,
                'options' => ['prompt' => 'Боғланиш танланг ...','multiple'=>false],
                'theme' => Select2::THEME_BOOTSTRAP,
                'pluginOptions' => [
                    'allowClear' => true
                ],
                'theme' => Select2::THEME_BOOTSTRAP,
                // 'theme' => \kartik\select2\Select2::THEME_MATERIAL,
            ]) ?>

    <?= $form->field($model, 'POKAZ_CODE')->widget(Select2::classname(), [
                'data' => $pokazs,
                'options' => ['prompt' => 'Показ танланг ...','multiple'=>false],
                'pluginOptions' => [
                    'allowClear' => true
                ],
                'theme' => Select2::THEME_BOOTSTRAP,
                // 'theme' => \kartik\select2\Select2::THEME_MATERIAL,
            ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Саклаш', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
