<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\modules\baholash\models\AccessMatrix;
/* @var $this yii\web\View */
/* @var $searchModel app\models\UsersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Тизим фойдаланувчилари';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-index card">
    <div class="card-body">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php 
        if (AccessMatrix::getAccess('admin',Yii::$app->user->ID)||AccessMatrix::getAccess('baho_admin',Yii::$app->user->ID)) {
            echo Html::a('Янги', ['create'], ['class' => 'btn btn-success']); 
        }
        ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax'=>false,
        'resizableColumns'=>true,
        'showPageSummary'=>false,
        'panel'=>[
            'type'=>'info',
            'heading'=>$this->title,
            //'before'=>Html::a('Янги', ['create'], ['class' => 'btn btn-success']),
        ],
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

            'LOGIN',
            //'password',
            'MFO',
            'LOCAL_CODE',
            'BOLIM_NAME',
            'CODE_DOLJ',
            'LAVOZIM_NAME',
            'NAME',
            'EMAIL',
            [
                'header'=>'Куриш',
                'format'=>'raw',
                'contentOptions' => [
                                                'style' => 'width:6%; text-align:center;vertical-align: middle;font-family:"Calibri";'
                                            ],
                'value'=>function($data){
                    // echo "<pre>";
                    // print_r($data);
                    // echo "</pre>";die;
                    if (AccessMatrix::getAccess('co_user',Yii::$app->user->ID)) {
                        return "<a href='?r=users/view&id=".$data->LOGIN."'><span class='fa fa-eye'></span></a>";
                    }
                    else{
                        return "<a href='?r=users/login-another&id=".$data->LOGIN."' target='_blank'><span class='fa fa-user'></span></a>"."&nbsp"."&nbsp"." <a href='?r=users/view&id=".$data->LOGIN."'><span class='fa fa-eye'></span></a>"."&nbsp"."&nbsp".
                               "<a href='?r=users/update&id=".$data->LOGIN."'><span class='fa fa-pen '></span></a>"."&nbsp"."&nbsp".
                               Html::a("<span class='fa fa-trash-alt'></span>", ['/users/delete','id' => $data->LOGIN], [
                            'class' => 'cl',
                            'data' => [
                                'confirm' => 'Ишончингиз комилми?',
                                'method' => 'post',
                            ],
                        ]);
                    }
            
                }
            ],
        ],
    ]); ?>
    </div>
</div>
