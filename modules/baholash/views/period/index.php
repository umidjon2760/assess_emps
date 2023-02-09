<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\baholash\models\PeriodSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Период';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="period-index card">
    <div class="card-body">

    <p>
        <?= Html::a('Янги', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
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
            'PERIOD',
            'IS_OPEN'=>[
                'attribute'=>'IS_OPEN',
                'format'=>'raw',
                'filter'=>['0'=>'Ёпиқ','1'=>'Очиқ'],
                'value'=>function($data)
                {
                    return (isset(['0'=>'Ёпиқ','1'=>'Очиқ'][$data->IS_OPEN]) ? [''=>'Танланг...','0'=>'Ёпиқ','1'=>'Очиқ'][$data->IS_OPEN] : $data->IS_OPEN);
                }
            ],

            ['class' => 'kartik\grid\ActionColumn'],
        ],
    ]); ?>

    </div>
</div>
