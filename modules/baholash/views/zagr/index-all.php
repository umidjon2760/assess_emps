<?php



use yii\helpers\Html;
use kartik\grid\GridView;
use app\modules\baholash\models\Session;
use app\modules\baholash\models\Fact;
use app\modules\baholash\models\Period;
use app\modules\baholash\models\Filials;
use yii\bootstrap4\Modal;
/* @var $this yii\web\View 1*/
/* @var $searchModel app\models\FactSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'Бахолаш (360)';
$this->params['breadcrumbs'][] = $this->title;
//$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index']];
$session = Session::getSessionMe('only_360');
$filials = Filials::getAll();
// var_dump($session);die;
if($session>0&&$session<5){
    $this->title = 'Бахолаш (360)';

?>
<div class="kpi-fact-index">

   


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            'LOCAL_CODE'=>[
                'attribute'=>'LOCAL_CODE',
                'format'=>'raw',
                'filter'=>$filials,
                'value'=>function($data) use ($filials)
                {
                    return (isset($filials[$data->LOCAL_CODE]) ? $filials[$data->LOCAL_CODE] : $data->LOCAL_CODE);
                }
            ],
            'NAME',
            // 'CODE_DOLJ',
            'BOLIM_NAME',
            'LAVOZIM_NAME',
            [
                'header'=>'Бахолар',
                'format'=>'raw',
                'contentOptions' => [
                    'style' => 'width:7%;text-align:center;  '
                ],
                'value'=>function($data){
                    // echo "<pre>";
                    // print_r($data);
                    // echo "</pre>";die;
                    $avg = Fact::getAvgValue($data->INPS,Period::getPeriod(),'only_360').'%';
                     Modal::begin([
                            'title' => "<h2 style='text-align:center;'>Бахоланувчи</h2>",
                            'id'=>'your-modal'.$data->INPS,
                            'size'=>'modal-xl',
                        ]);
                        echo "<div id='mod".$data->INPS."'><span class='status-icon color-warning'><i class='fas fa-spinner'></i></span><span> Юкланмоқда...</span></div>";
                        Modal::end(); 
                    return Html::button(
                                       $avg, [
                                            //'value'=>Yii::$app->UrlManager->createUrl('/baho-Zagr-session/bahootchot'.$data->ID),
                                            'class'=>'btn btn-primary btn-sm',
                                            'id' => $data->INPS,
                                            'data-toggle' => 'modal',
                                            'data-target' => '#your-modal'.$data->INPS,
                                            'onclick'=>'modal('.$data->INPS.',"only_360")',
                                        ]
                                    );
                    
            
                }
            ],
            [
                'header' => 'Бахолаш', 
                'format' => 'raw', 
                
                'contentOptions' => function ($data) {
                    return  Fact::getClass($data->INPS,'only_360');
                },

                'value' => function ($data) {
                        return Fact::getLink($data->INPS,'only_360');
                        //return "<a href='?r=kpi-fact/ocenka&id=".$data->ID."'>".'Оценить'.$session."</a>";
                    
                }
            ],
        ],
    ]); ?>
</div>

<?php

$alert = Fact::getMyInfoFull('only_360');
if($alert==1&&$session==1){
echo '<p id="ogox">Ходимларни бахолаб булганингиздан сунг илтимос "Бахолашни якунлаш" тугмасини босинг.';
echo Html::a(
    'Бахолашни якунлаш',
    ['/baholash/zagr/closemysession','group'=>'only_360'],
    [
        'data-confirm' => 'Сиз бахолашни якунламокдасиз. Бахолаш якунланганидан сунг бахоларни узгартириш имкони мавжуд эмас.',
        'class'        => 'btn btn-primary',
        'id'           => 'ogoxbut'
    ]
);
echo "</p>";
}

if($alert==2&&$session==1){
echo '<p id="ogox">Бахолашни якунлаш учун барча ходимларни бахолашингиз керак.';
echo Html::button(
        'Бахолашни якунлаш',
        [
            'class' => 'btn btn-danger',
            'id'    => 'ogoxbut',
            'disabled' => 'disabled'
        ]
    );

echo "</p>";
}


}
else{
    $this->title = 'Сессия очилмаган!';
?>
<h1><?= Html::encode($this->title) ?></h1>
<?php
}
?>
<script type="text/javascript">
    function modal(cbid,group)
    {
          $.ajax({
              url: "?r=baholash/session/getmodalajax1",
              type: "POST",
              data: ({ 
                cbid: cbid,
                group: group,
                _csrf : '<?=Yii::$app->request->getCsrfToken()?>' 
              }),
              success: function(data) {
                  document.getElementById('mod'+cbid).innerHTML = data ;    // здесь задаете новое значение для инпута
              }
          });

    }
</script>




<style type="text/css">
    #ogoxbut{
        
        float: right;
    }
    p#ogox{
        font-size: 24px;
        color:red;
        font-weight: bold;
    }
    .red{
        background-color:#d43f3a;
    }

    .red a{
        color:white;
    }
    .orange{
        background-color:orange;
    }

    .orange a{
        color:white;
    }
    .green{
        background-color:#5cb85c;
    }

    .green a{
        color:white;
    }
</style>