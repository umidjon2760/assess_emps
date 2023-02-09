<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\modules\baholash\models\KpiCard;
use app\modules\baholash\models\Period;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\baholash\models\ZagrSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ходимлар';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="zagr-index card">
    <div class="card-body">


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'floatHeader'=>true,
        'floatHeaderOptions'=>['scrollingTop'=>'0','position'=>'absolute'],
        'pjax'=>true,
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
            'CBID',
            'INPS',
            'MFO',
            'LOCAL_CODE',
            'NAME',
            //'BOLIM_CODE',
            'BOLIM_NAME',
            'CODE_DOLJ',
            'LAVOZIM_NAME',
            //'TABEL',
            //'PERIOD',
            [
                'header'=>'KPI',
                'format'=>'raw',
                'contentOptions'=>['style'=>'text-align:center;vertical-align:middle;'],
                'value'=>function($data)
                {
                    $kpi = KpiCard::getKpi($data->INPS,Period::getPeriod());
                    if ($kpi==999) {
                        return "<span class='fas fa-spinner'></span>";   
                    }
                    else{
                        return $kpi.'%';
                    }
                }
            ],
            [
                'header'=>'KPI',
                'format'=>'raw',
                'contentOptions'=>['style'=>'text-align:center;vertical-align:middle;'],
                
                'value'=>function($data)
                {
                    return "<a href='?r=baholash/kpi-card/index&bfdo1NGa1JkjfMn78t82dM17V=".$data->INPS."&oe63p0LOioXr16zlQ2IOSf2cr=' class='btn btn-info'>KPI</a>";
                }
            ],
            // ['class' => 'kartik\grid\ActionColumn'],
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