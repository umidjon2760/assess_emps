<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\modules\baholash\models\Period;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\baholash\models\KpiCardSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'KPI карта';
$this->params['breadcrumbs'][] = $this->title;


?>
<div class="kpi-card-index card">
    <div class="card-body">
    <p>
        <a href='?r=baholash/zagr/send-to-emp-kpi' class='btn btn-danger' data-confirm='Барча ходимларга KPI хақида хабар юбормоқчимисиз?'>Огохлантириш</a>
    </p>
    <!-- <a href='?r=baholash/zagr/emp-kpi' class='btn btn-info'>Орқага</a><br><br> -->
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax'=>true,
        'resizableColumns'=>true,
        'showPageSummary'=>false,
        'pageSummaryRowOptions' => ['style' => 'background:lightgray;'],
        // 'showFooter' => true,
        'panel'=>[
            'type'=>'info',
            'heading'=>'KPI карталар',
            // 'before'=>Html::a('Орқага', ['/baholash/zagr/emp-kpi'], ['class' => 'btn btn-info']),
            // 'after'=>Html::tag('p', 'KPI - 100', ['class' => 'text text-right text-bold']),
            'footer'=>false
        ],
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

            // 'ID',
            
            'INPS',
            'MFO',
            'LOCAL_CODE',
            'CODE_DOLJ',
            //'KPI_METHOD',
            //'TABNUM',
            'ORD',
            'CRITERIY_NAME'=>[
                'attribute'=>'CRITERIY_NAME',
                'contentOptions'=>['style'=>'width:10%;vertical-align:middle;'],
            ],
            'CRITERIY_ALGORITHM'=>[
                'attribute'=>'CRITERIY_ALGORITHM',
                'contentOptions'=>['style'=>'width:15%;vertical-align:middle;'],
            ],
            //'MIN_VALUE',
            //'AVG_VALUE',
            //'MAX_VALUE',
            'VES'=>[
                'attribute'=>'VES',
                'contentOptions'=>['style'=>'width:5%;text-align:center;vertical-align:middle;'],
                'value' => function ($data) {
                    $ret = number_format($data->VES*100, 0, ',', ' ');
                    return $ret.'%';
                }
            ],
            'PLAN'=>[
                'attribute'=>'PLAN',
                'contentOptions'=>['style'=>'width:5%;text-align:center;vertical-align:middle;'],
                'value' => function ($data) {
                    $ret = number_format($data->PLAN, 2, ',', ' ');
                    return $ret;
                }
            ],
            'FACT'=>[
                'attribute'=>'FACT',
                'contentOptions'=>['style'=>'width:5%;text-align:center;vertical-align:middle;'],
                'value' => function ($data) {
                    $ret = number_format($data->FACT, 2, ',', ' ');
                    return $ret;
                }
            ],
            'BAJARILISH'=>[
                'attribute'=>'BAJARILISH',
                'contentOptions'=>['style'=>'width:5%;text-align:center;vertical-align:middle;'],
                'value' => function ($data) {
                    $ret = number_format($data->BAJARILISH*100, 2, ',', ' ');
                    return $ret;
                }
            ],
            'IVSH'=>[
                'attribute'=>'IVSH',
                'contentOptions'=>['style'=>'width:5%;text-align:center;vertical-align:middle;'],
                // 'pageSummary' => 'KPI',
                // 'pageSummaryOptions' => ['class' => 'text-right text-end'],
                'value' => function ($data) {
                    $ret = number_format($data->IVSH*100, 2, ',', ' ');
                    return $ret;
                }
            ],
            'CRITERIY_KPI'=>[
                'attribute'=>'CRITERIY_KPI',
                'contentOptions'=>['style'=>'width:5%;text-align:center;vertical-align:middle;'],
                'value' => function ($data) {
                    $ret = $data->CRITERIY_KPI*100;
                    return $ret;
                },
                // 'format' => ['decimal', 2],
                // 'pageSummary' => true,
                // 'pageSummaryOptions' => ['class' => 'text-center'],
            ],
            'PERIOD'=>[
                'attribute'=>'PERIOD',
                'filter'=>Period::getAllPeriods()
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    </div>
</div>
<style>
    .kv-page-summary{
        background:lightgray;
    }
</style>