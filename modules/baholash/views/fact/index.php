<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap4\Modal;
use kartik\select2\Select2;
use app\modules\baholash\models\RelationGroup;
use app\modules\baholash\models\Zagr;
use app\modules\baholash\models\Period;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\baholash\models\FactSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$periods = Period::getAllPeriods();
$this->title = 'Бахолар';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fact-index card">
    <div class="card-body">

    
        <?= Html::a('Янги', ['create'], ['class' => 'btn btn-success']) ?>
        <?php
        Modal::begin([
          'title' => "<p style='text-align:center;'>Гурух белгиланг</p>",
          'id'=>'your-modall',
          // 'size'=>'modal-lg',
        ]);
        echo Html::beginForm(['/baholash/relation/baho-start'], 'post');
        echo "<label>Гурух белгиланг...</label>";
        echo Select2::widget([
            'name' => 'groups',
            'data' => RelationGroup::getAll(),
            // 'data' => [],
            'options' => [
                'placeholder' => 'Гурух танланг...',
                'multiple' => false,
                'required' => true,
                'class'=>'filch',
                // 'id'=>'xodims'
            ],
            'theme' => Select2::THEME_BOOTSTRAP,
        ]);
        echo "<br><input type='submit' value='Сақлаш'' class='btn btn-primary' />";
               // echo "</form>";
        echo Html::endForm(); 
        Modal::end();
        echo Html::button(
           'Кайта ишлаш', [
                'class'=>'btn btn-danger ',
                // 'id' => $data->ID,
                'data-toggle' => 'modal',
                'title' => 'Кайта ишлаш',
                'data-target' => '#your-modall',
            ]
        );
        ?>
    <br><br>


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

            'GROUP_CODE'=>[
                'attribute'=>'GROUP_CODE',
                'contentOptions'=>[
                    'style'=>'width:7%;text-align:center;'
                ],
            ],
            'LOV_ID'=>[
                'attribute'=>'LOV_ID',
                'contentOptions'=>[
                    'style'=>'width:10%;text-align:center;'
                ],
            ],
            [
                'attribute'=>'lovmfo',
                'label'=>'Бахоловчи<br>локал коди',
                'encodeLabel' => false,
                'format'=>'raw',
                'contentOptions'=>[
                    'style'=>'width:7%;text-align:center;'
                ],
                'value'=>'lovmfo.LOCAL_CODE'
            ],

            [
                'attribute'=>'lovcodedolj',
                'label'=>'Бахоловчи<br>лавозим<br>коди',
                'encodeLabel' => false,
                'format'=>'raw',
                'contentOptions'=>[
                    'style'=>'width:7%;text-align:center;'
                ],
                'value'=>'lovcodedolj.CODE_DOLJ'
            ],
            // [
            //     'header'=>'lov mfo',
            //     'format'=>'raw',
            //     'value'=>function($data)
            //     {
            //         return Zagr::getLocalCode($data->LOV_ID);
            //     }
            // ],
            'NUV_ID'=>[
                'attribute'=>'NUV_ID',
                'contentOptions'=>[
                    'style'=>'width:10%;text-align:center;'
                ],
            ],
            [
                'attribute'=>'nuvmfo',
                'label'=>'Бахоланувчи<br>локал коди',
                'encodeLabel' => false,
                'format'=>'raw',
                'contentOptions'=>[
                    'style'=>'width:7%;text-align:center;'
                ],
                'value'=>'nuvmfo.LOCAL_CODE'
            ],
            [
                'attribute'=>'nuvcodedolj',
                'format'=>'raw',
                'label'=>'Бахоланувчи<br>лавозим<br>коди',
                'encodeLabel' => false,
                'contentOptions'=>[
                    'style'=>'width:7%;text-align:center;'
                ],
                'value'=>'nuvcodedolj.CODE_DOLJ'
            ],
            // [
            //     'header'=>'nuv mfo',
            //     'format'=>'raw',
            //     'value'=>function($data)
            //     {
            //         return Zagr::getLocalCode($data->NUV_ID);
            //     }
            // ],

            // [
            //     'header'=>'check',
            //     'format'=>'raw',
            //     'value'=>function($data)
            //     {
            //         // echo "<pre>";
            //         // print_r($data->lovmfo->LOCAL_CODE);
            //         // echo "</pre>";die;
            //         $lov = Zagr::getLocalCode($data->LOV_ID);
            //         $lov1 = $data->lovmfo->LOCAL_CODE;
            //         $nuv = Zagr::getLocalCode($data->NUV_ID);
            //         $nuv1 = $data->nuvmfo->LOCAL_CODE;
            //         if ($lov==$lov1) {
            //             $check_lov = $lov.'#'.$lov1.'#OK_lov';
            //         }
            //         else{
            //             $check_lov = $lov.'#'.$lov1.'#Error_lov';
            //         }
            //         if ($nuv==$nuv1) {
            //             $check_nuv = $nuv.'#'.$nuv1.'#OK_nuv';
            //         }
            //         else{
            //             $check_nuv = $nuv.'#'.$nuv1.'#Error_nuv';
            //         }
            //         return $check_lov.'<br>'.$check_nuv;
            //     }
            // ],
            'POKAZ_CODE'=>[
                'attribute'=>'POKAZ_CODE',
                'contentOptions'=>[
                    'style'=>'width:5%;text-align:center;'
                ],
            ],
            'VALUE'=>[
                'attribute'=>'VALUE',
                'contentOptions'=>[
                    'style'=>'width:5%;text-align:center;'
                ],
            ],
            'COMMENT'=>[
                'attribute'=>'COMMENT',
                'contentOptions'=>[
                    'style'=>'width:20%;text-align:left;'
                ],
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