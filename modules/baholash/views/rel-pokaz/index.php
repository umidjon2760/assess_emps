<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\modules\baholash\models\Relation;
use app\modules\baholash\models\Pokaz;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\baholash\models\RelPokazSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Богланиш показатель';
$this->params['breadcrumbs'][] = $this->title;
$rels = Relation::getAllRelationID();
?>
<div class="rel-pokaz-index card">
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
        ],
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            [
                'attribute'=>'relid',
                'label'=>'Богланиш ID',
                'format'=>'raw',
                'contentOptions'=>[
                    'style'=>'width:7%;text-align:center;'
                ],
                'value'=>'relid.ID'
            ],
            'REL_ID'=>[
                'attribute'=>'REL_ID',
                'label'=>'Богланиш ID номи',
                'filter' => [''=>'Барча'] + $rels,
                'filterType' => GridView::FILTER_SELECT2,
                'value'=>function($data)
                {
                    $rel = Relation::find()->where(['ID'=>$data->REL_ID])->one();
                    if ($rel) {
                        return $rel->GROUP_CODE.' - '.$rel->NUV_DOLJ_CODE.' - '.$rel->LOV_DOLJ_CODE1.' - '.$rel->LOV_DOLJ_CODE2.' - '.$rel->LOV_DOLJ_CODE3;
                    }
                    else{
                        return 'Топилмади!';
                    }
                }
            ],
            [
                'attribute'=>'pokaz',
                'label'=>'Показатель',
                'format'=>'raw',
                'contentOptions'=>[
                    'style'=>'width:10%;text-align:left;'
                ],
                'value'=>'pokaz.CODE'
            ],
            [
                'attribute'=>'POKAZ_CODE',
                'label'=>'Показатель нопи',
                'format'=>'raw',
                'contentOptions'=>[
                    'style'=>'width:42%;text-align:left;'
                ],
                'filter' => [''=>'Барча'] + Pokaz::getAll(),
                'filterType' => GridView::FILTER_SELECT2,
                'value'=>function($data)
                {
                    $all = Pokaz::getAll();
                    return (isset($all[$data->POKAZ_CODE]) ? $all[$data->POKAZ_CODE] : $data->POKAZ_CODE);
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