<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\modules\baholash\models\Period;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\baholash\models\SessionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Сессиялар';
$this->params['breadcrumbs'][] = $this->title;
$periods = Period::getAllPeriods();
?>
<div class="session-index card">
    <div class="card-body">

    <p>
        <?= Html::a('Янги', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax'=>true,
        'floatHeader'=>true,
        'floatHeaderOptions'=>['scrollingTop'=>'0','position'=>'absolute'],
        'resizableColumns'=>true,
        'showPageSummary'=>false,
        'panel'=>[
            'type'=>'info',
            'heading'=>$this->title,
            //'before'=>Html::a('Янги', ['create'], ['class' => 'btn btn-success']),
        ],
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

            // 'ID',
            'MFO'=>[
                'attribute'=>'MFO',
                'contentOptions'=>[
                    'style'=>'width:7%;text-align:center;'
                ],
            ],
            [
                'attribute'=>'lovmfo',
                'label'=>'МФО',
                'format'=>'raw',
                'contentOptions'=>[
                    'style'=>'width:7%;text-align:center;'
                ],
                'value'=>'lovmfo.MFO'
            ],
            'LOV_ID'=>[
                'attribute'=>'LOV_ID',
                'contentOptions'=>[
                    'style'=>'width:10%;text-align:center;'
                ],
            ],
            [
                'attribute'=>'lovname',
                'label'=>'ФИО',
                'format'=>'raw',
                'contentOptions'=>[
                    'style'=>'width:35%;text-align:left;'
                ],
                'value'=>'lovname.NAME'
            ],
            [
                'attribute'=>'lovcodedolj',
                'label'=>'Лавозим коди',
                'format'=>'raw',
                'contentOptions'=>[
                    'style'=>'width:7%;text-align:center;'
                ],
                'value'=>'lovcodedolj.CODE_DOLJ'
            ],
            'GROUP_CODE'=>[
                'attribute'=>'GROUP_CODE',
                'contentOptions'=>[
                    'style'=>'width:7%;text-align:center;'
                ],
            ],
            'SESSION_ID'=>[
                'attribute'=>'SESSION_ID',
                'contentOptions'=>[
                    'style'=>'width:7%;text-align:center;'
                ],
                'format'=>'raw',
                'filter'=>['1'=>'Очиқ','2'=>'Ёпиқ'],
                'value'=>function($data){
                    return (isset(['1'=>'Очиқ','2'=>'Ёпиқ'][$data->SESSION_ID]) ? ['1'=>'Очиқ','2'=>'Ёпиқ'][$data->SESSION_ID] : $data->SESSION_ID);
                }
            ],
            'PERIOD'=>[
                'attribute'=>'PERIOD',
                'filter' => [''=>'Барча'] + $periods,
                'contentOptions'=>[
                    'style'=>'width:8%;text-align:center;'
                ],
                'filterType' => GridView::FILTER_SELECT2,
                'value'=>function($data) use ($periods)
                {
                    return (isset($periods[$data->PERIOD]) ? $periods[$data->PERIOD] : $data->PERIOD);
                }
            ],

            ['class' => 'kartik\grid\ActionColumn'],
        ],
    ]); ?>

    </div>
</div>
<style type="text/css">
    thead tr th{
        text-align: center;
    }
    .grid-view thead{
        background: #B0E0DC;
    }
</style>