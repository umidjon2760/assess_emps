<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\modules\baholash\models\Session;
use app\modules\baholash\models\Fact;
use app\modules\baholash\models\Zagr;
use app\modules\baholash\models\Period;
use yii\bootstrap4\Modal;
use yii\widgets\Pjax;
if ($_GET['group']=='only_360') {
    $this->title = 'Сессия (360)';
    $title = '?r=baholash/session/fil-all-session';
}
else{
    $this->title = 'Сессия (KPI)';
    $title = '?r=baholash/session/fil-kpi-session';
}
$act_class = date('n',strtotime($period));
$bred='';
$bred.="<a href='?r=site/index'>Асосий</a>&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;";
$bred.="<a href='".$title."'>".$this->title."</a>&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;";
for ($i=1; $i < 13; $i++) { 
    if($act_class==$i){
        $bred.="<a style='margin-left:5px;' href='?r=baholash/session/fil-view&code=".$code."&group=".$group."&oy=".$i."' class=' btnpr'>".Period::getMonthName($i)."</a>&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;";  
    }
    elseif ($i==date('n',strtotime(Period::getPeriod()))) {
        $bred.="<a style='font-weight:bold;' href='?r=baholash/session/fil-view&code=".$code."&group=".$group."&oy=".$i."'>".mb_strtoupper(Period::getMonthName($i))."</a>&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;";
    }    
    else{
        $bred.="<a  href='?r=baholash/session/fil-view&code=".$code."&group=".$group."&oy=".$i."'>".Period::getMonthName($i)."</a>&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;";
    }
}
$bred = substr($bred, 0,-19);
echo "<p style='position:relative;bottom:18px;margin-left:5px;'>".$bred."</p>";
?>
<div class="session-index">

    <h1><?= Html::encode($this->title." ".$code) ?></h1>
    <h3><?= Html::encode('Период - '.date("d-m-Y",strtotime($period))) ?></h3>
    <?php
    if ($period==Period::getPeriod()) {
    ?>
        <p>
            <?= Html::a('Янги сессия очиш', ['opentooneforfil','mfo'=>$code], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Бахолашни очиш', ['backtosessionforfilnokpifact','mfo'=>$code,'session_id'=>'1','group'=>$group], ['class' => 'btn btn-primary']) ?>
            <?=Html::a('Бахолашни ёпиш', ['backtosessionforfilnokpifact','mfo'=>$code,'session_id'=>'2','group'=>$group], ['class' => 'btn btn-danger']);?>
        </p>
    <?php    
    }
    ?>
<?php
?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

            'LOV_ID'=>[
                'attribute'=>'LOV_ID',
                'contentOptions'=>['style'=>'width:6%'],
            ],
            [
                'label' => 'ФИО',
                'contentOptions'=>['style'=>'width:27%'],
                'value' => function ($data) {
                    return Zagr::getName($data->LOV_ID);
                },
            ],
            [
                'label' => 'Должность',
                'contentOptions'=>['style'=>'width:39%'],
                'value' => function ($data) {
                    return Zagr::getBolimname($data->LOV_ID).' '.Zagr::getDoljName($data->LOV_ID);
                },
            ],
            'SESSION_ID'=>[
                'attribute' => 'SESSION_ID',
                'contentOptions'=>['style'=>'width:15%'],
                'filter' => Session::getAll(),
                'format'=>'raw',
                'value' => function ($data) {
                    $nisbat = Fact::getBahoOrNot($data->LOV_ID,$data->PERIOD,$data->GROUP_CODE);
                    return Session::getName($data->SESSION_ID).' <b>('.$nisbat.')</b>';
                },
            ],
            [
                'header'=>'Куриш',
                'format'=>'raw',
                'contentOptions' => [
                                                'style' => 'width:9%; min-width:9%;  text-align:center;'
                                            ],
                'value'=>function($data){
                     Modal::begin([
                            'title' => "<h2 style='text-align:center;'>Бахоланувчилар</h2>",
                            'id'=>'your-modal'.$data->LOV_ID,
                            'size'=>'modal-xl',
                        ]);
                        echo "<div id='mod".$data->LOV_ID."'><span class='status-icon color-warning'><i class='fas fa-spinner'></i></span><span> Юкланмоқда...</span></div>";
                        Modal::end(); 
                    return Html::button(
                                       'Куриш', [
                                            'class'=>'btn btn-primary btn-sm',
                                            'id' => $data->LOV_ID,
                                            'data-toggle' => 'modal',
                                            'data-target' => '#your-modal'.$data->LOV_ID,
                                            'onclick'=>'modal('.$data->LOV_ID.',"'.$_GET['group'].'","'.$data->PERIOD.'")',
                                        ]
                                    )."&nbsp"."&nbsp".
                           "<a href='?r=baholash/session/update&id=".$data->ID."'><span class='fa fa-pen '></span></a>"."&nbsp"."&nbsp".
                           Html::a("<span class='fa fa-trash-alt'></span>", ['/baholash/session/delete','id' => $data->ID], [
                        'class' => 'cl',
                        'data' => [
                            'confirm' => 'Ишончингиз комилми?',
                            'method' => 'post',
                        ],
                    ]);
            
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


</style>
<script type="text/javascript">
    function btn(lov){
    checkboxes=document.getElementsByClassName('baholash');
    var count=0;
    len=checkboxes.length;
    for(var j=0;j<len;j++){
        if(checkboxes[j].checked){
            count++;
            }
        }
    if(count>=1){
      document.getElementById('delete'+lov).disabled=false;
    }
    else{
      document.getElementById('delete'+lov).disabled=true;
    }

    }
</script>