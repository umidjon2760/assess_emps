<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\baholash\models\FilialsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Филиаллар';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="filials-index card">
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
            'MFO',
            'LOCAL_CODE',
            'NAME',

            ['class' => 'kartik\grid\ActionColumn'],
        ],
    ]); ?>

    </div>
</div>
