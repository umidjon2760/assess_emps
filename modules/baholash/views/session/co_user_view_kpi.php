<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\modules\baholash\models\Session;
use app\modules\baholash\models\Zagr;
use app\modules\baholash\models\Period;
use app\modules\baholash\models\Fact;
use yii\bootstrap4\Modal;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\SessionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Филиал бахолаш (KPI)';

// Html::a('Открыть сессию за текущий месяц', ['opencurmonth1','mfo'=>$code], ['class' => 'btn btn-primary'])
//Html::a('Закрыть сессию оценок', ['closebaho1','mfo'=>$code], ['class' => 'btn btn-danger']);
// Html::a('Открыть сессию для подтверждения расчетов', ['open3_fil','mfo'=>$code], ['class' => 'btn btn-primary']);
$act_class = date('n',strtotime($period));
$bred='';
$bred.="<a href='?r=site/index'>Асосий</a>&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;";
for ($i=1; $i < 13; $i++) { 
    if($act_class==$i){
        $bred.="<a style='margin-left:5px;' href='?r=baholash/session/filial-baho-kpi&oy=".$i."' class=' btnpr'>".Period::getMonthName($i)."</a>&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;";  
    } 
    elseif ($i==date('n',strtotime(Period::getPeriod()))) {
        $bred.="<a style='font-weight:bold;' href='?r=baholash/session/filial-baho-kpi&oy=".$i."'>".mb_strtoupper(Period::getMonthName($i))."</a>&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;";
    }  
    else{
        $bred.="<a  href='?r=baholash/session/filial-baho-kpi&oy=".$i."'>".Period::getMonthName($i)."</a>&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;";
    }
    
}
$bred = substr($bred, 0,-19);
echo "<p style='position:relative;bottom:18px;margin-left:5px;'>".$bred."</p>";
// var_dump($act_class);
?>
<div class="session-index">

    <h3><?= Html::encode(date("d.m.Y",strtotime($period))) ?></h3>
    
    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    

<?php

?>




    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

            //'ID',
            //'PERIOD',
            // 'MFO'=>[
            //     'attribute'=>'MFO',
            //     'contentOptions'=>['style'=>'width:5%'],
            // ],
            'LOV_ID'=>[
                'attribute'=>'LOV_ID',
                'contentOptions'=>['style'=>'width:10%'],
            ],
            [
                'label' => 'ФИО',
                'contentOptions'=>['style'=>'width:28%'],
                'value' => function ($data) {
                    return Zagr::getName($data->LOV_ID);
                },
            ],
            [
                'label' => 'Должность',
                'contentOptions'=>['style'=>'width:40%'],
                'value' => function ($data) {
                    return Zagr::getBolimnamebyPeriod($data->LOV_ID,$data->PERIOD).' '.Zagr::getDoljNameByPeriod($data->LOV_ID,$data->PERIOD);
                },
            ],
            'SESSION_ID'=>[
                'attribute' => 'SESSION_ID',
                'contentOptions'=>['style'=>'width:13%'],
                'filter' => Session::getAll(),
                'format'=>'raw',
                'value' => function ($data) {
                    $nisbat = Fact::getBahoOrNot($data->LOV_ID,$data->PERIOD,$data->GROUP_CODE);
                    return Session::getName($data->SESSION_ID).' <b>('.$nisbat.')</b>';
                },
            ],

            // ['class' => 'kartik\grid\ActionColumn'],
            [
                'header'=>'Куриш',
                'format'=>'raw',
                'contentOptions' => [
                                                'style' => 'width:6%; min-width:6%;  text-align:center;'
                                            ],
                'value'=>function($data) use ($group,$period){
                    // echo "<pre>";
                    // print_r($data);
                    // echo "</pre>";die;
                     Modal::begin([
                            'title' => "<h2 style='text-align:center;'>Бахоланувчилар</h2>",
                            'id'=>'your-modal'.$data->LOV_ID,
                            'size'=>'modal-lg',
                        ]);
                        echo "<div id='mod".$data->LOV_ID."'><span class='status-icon color-warning'><i class='fas fa-spinner'></i></span><span> Юкланмоқда...</span></div>";
                        Modal::end(); 
                    return Html::button(
                                       'Куриш', [
                                            //'value'=>Yii::$app->UrlManager->createUrl('/baho-Zagr-session/bahootchot'.$data->ID),
                                            'class'=>'btn btn-primary btn-sm',
                                            'id' => $data->LOV_ID,
                                            'data-toggle' => 'modal',
                                            'data-target' => '#your-modal'.$data->LOV_ID,
                                            'onclick'=>'modal('.$data->LOV_ID.',"'.$group.'","'.$period.'")',
                                        ]
                                    )
                           ;
            
                }
            ],
        ],
    ]); ?>
</div>

<script type="text/javascript">
    function modal(cbid,group,period)
    {
          $.ajax({
              url: "?r=baholash/session/getmodalajax",
              type: "POST",
              data: ({ 
                cbid: cbid,
                group: group,
                period: period,
                _csrf : '<?=Yii::$app->request->getCsrfToken()?>' 
              }),
              success: function(data) {
                  document.getElementById('mod'+cbid).innerHTML = data ;    // здесь задаете новое значение для инпута
              }
          });

    }
</script>
<style type="text/css">
    .btnpr{
        border:1px solid #337AB7;
        background: #337AB7;
        padding: 5px 10px;
        color: white;
    }
    .btnpr:hover{
        color:white;
        border-radius:5px;
    }
    /*#ogoxbut{
        
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
    }*/
</style>