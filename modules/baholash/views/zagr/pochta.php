<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\baholash\models\ZagrSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Почта (тест)';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="zagr-index card">
    <div class="card-body">
    <?php
    echo Html::beginForm(['/baholash/zagr/pochta'], 'post');
    echo Html::input('email', 'email', '', ['class' => 'form-control','required'=>'required','placeholder'=>'example@universalbank.uz']);
    echo "<br>";
    echo Html::textArea('text', '', ['class' => 'form-control','required'=>'required','placeholder'=>'Матн киритинг...']);
    echo "<br>";
    echo Html::submitButton('Жўнатиш', ['class' => 'btn-info btn-sm']);
    echo Html::endForm();
    ?>
   

    </div>
</div>