<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\baholash\models\ZagrSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Загруженность';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="zagr-index card">
    <div class="card-body">

    <p>
        <?= Html::a('Янги', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


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