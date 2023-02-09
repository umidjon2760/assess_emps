<?php

use yii\helpers\Html;
use kartik\select2\Select2;
use app\modules\baholash\models\Period;
use app\modules\baholash\models\RelationGroup;
use app\modules\baholash\models\Fact;
use app\modules\baholash\models\Zagr;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\baholash\models\ZagrSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Бахолар';
$this->params['breadcrumbs'][] = $this->title;

$data = Period::getAllPeriods();
?>
<div class="zagr-index card">
    <div class="card-body">
        <?=Select2::widget([
            'name' => 'metod',
            'data' => $data,
            // 'data' => [],
            'options' => [
                'placeholder' => 'Давр танланг...',
                'multiple' => true,
                
                'class'=>'widthauto',
                
                'id'=>'met',
                'onchange'=>'getloading();getdivajax();'
            ],
            'theme' => Select2::THEME_BOOTSTRAP,
        ]);?><br>
        
        <div id="divajax">
          <?php
          $groups = RelationGroup::getAll();
              echo "<table class='table table-bordered'>";
              echo "<tr>";
              echo "<td colspan='4'><b>".date('d.m.Y',strtotime(Period::getPeriod()))."</b></td>";
              echo "</tr>";
              foreach ($groups as $group_code => $group_name) {
                  $facts = Fact::find()->where(['NUV_ID'=>Yii::$app->user->ID])->andWhere(['GROUP_CODE'=>$group_code])->andWhere(['PERIOD'=>Period::getPeriod()])->all();
                  if ($facts) {
                    echo "<tr>";
                    echo "<td colspan='4'><b>".$group_name."</b></td>";
                    echo "</tr>";
                  }
                  $i = 1;
                  foreach ($facts as $fact) {
                      echo "<tr>";
                      echo "<td style='width:5%;'>".$i."</td>";
                      echo "<td style='width:40%;'>".Zagr::getPokazName($fact->POKAZ_CODE)."</td>";
                      echo "<td style='width:5%;'>".$fact->VALUE."</td>";
                      echo "<td style='width:40%;'>".$fact->COMMENT."</td>";
                      echo "</tr>";
                      $i++;
                  }
              }
              echo "</table>";
          ?>
        </div>


   

    </div>
</div>
<style type="text/css">
    .windows8 {
  position: relative;
  width: 78px;
  height:78px;
  margin:auto;
}

.windows8 .wBall {
  position: absolute;
  width: 74px;
  height: 74px;
  opacity: 0;
  transform: rotate(225deg);
    -o-transform: rotate(225deg);
    -ms-transform: rotate(225deg);
    -webkit-transform: rotate(225deg);
    -moz-transform: rotate(225deg);
  animation: orbit 6.96s infinite;
    -o-animation: orbit 6.96s infinite;
    -ms-animation: orbit 6.96s infinite;
    -webkit-animation: orbit 6.96s infinite;
    -moz-animation: orbit 6.96s infinite;
}

.windows8 .wBall .wInnerBall{
  position: absolute;
  width: 10px;
  height: 10px;
  background: rgb(0,0,0);
  left:0px;
  top:0px;
  border-radius: 10px;
}

.windows8 #wBall_1 {
  animation-delay: 1.52s;
    -o-animation-delay: 1.52s;
    -ms-animation-delay: 1.52s;
    -webkit-animation-delay: 1.52s;
    -moz-animation-delay: 1.52s;
}

.windows8 #wBall_2 {
  animation-delay: 0.3s;
    -o-animation-delay: 0.3s;
    -ms-animation-delay: 0.3s;
    -webkit-animation-delay: 0.3s;
    -moz-animation-delay: 0.3s;
}

.windows8 #wBall_3 {
  animation-delay: 0.61s;
    -o-animation-delay: 0.61s;
    -ms-animation-delay: 0.61s;
    -webkit-animation-delay: 0.61s;
    -moz-animation-delay: 0.61s;
}

.windows8 #wBall_4 {
  animation-delay: 0.91s;
    -o-animation-delay: 0.91s;
    -ms-animation-delay: 0.91s;
    -webkit-animation-delay: 0.91s;
    -moz-animation-delay: 0.91s;
}

.windows8 #wBall_5 {
  animation-delay: 1.22s;
    -o-animation-delay: 1.22s;
    -ms-animation-delay: 1.22s;
    -webkit-animation-delay: 1.22s;
    -moz-animation-delay: 1.22s;
}



@keyframes orbit {
  0% {
    opacity: 1;
    z-index:99;
    transform: rotate(180deg);
    animation-timing-function: ease-out;
  }

  7% {
    opacity: 1;
    transform: rotate(300deg);
    animation-timing-function: linear;
    origin:0%;
  }

  30% {
    opacity: 1;
    transform:rotate(410deg);
    animation-timing-function: ease-in-out;
    origin:7%;
  }

  39% {
    opacity: 1;
    transform: rotate(645deg);
    animation-timing-function: linear;
    origin:30%;
  }

  70% {
    opacity: 1;
    transform: rotate(770deg);
    animation-timing-function: ease-out;
    origin:39%;
  }

  75% {
    opacity: 1;
    transform: rotate(900deg);
    animation-timing-function: ease-out;
    origin:70%;
  }

  76% {
  opacity: 0;
    transform:rotate(900deg);
  }

  100% {
  opacity: 0;
    transform: rotate(900deg);
  }
}

@-o-keyframes orbit {
  0% {
    opacity: 1;
    z-index:99;
    -o-transform: rotate(180deg);
    -o-animation-timing-function: ease-out;
  }

  7% {
    opacity: 1;
    -o-transform: rotate(300deg);
    -o-animation-timing-function: linear;
    -o-origin:0%;
  }

  30% {
    opacity: 1;
    -o-transform:rotate(410deg);
    -o-animation-timing-function: ease-in-out;
    -o-origin:7%;
  }

  39% {
    opacity: 1;
    -o-transform: rotate(645deg);
    -o-animation-timing-function: linear;
    -o-origin:30%;
  }

  70% {
    opacity: 1;
    -o-transform: rotate(770deg);
    -o-animation-timing-function: ease-out;
    -o-origin:39%;
  }

  75% {
    opacity: 1;
    -o-transform: rotate(900deg);
    -o-animation-timing-function: ease-out;
    -o-origin:70%;
  }

  76% {
  opacity: 0;
    -o-transform:rotate(900deg);
  }

  100% {
  opacity: 0;
    -o-transform: rotate(900deg);
  }
}

@-ms-keyframes orbit {
  0% {
    opacity: 1;
    z-index:99;
    -ms-transform: rotate(180deg);
    -ms-animation-timing-function: ease-out;
  }

  7% {
    opacity: 1;
    -ms-transform: rotate(300deg);
    -ms-animation-timing-function: linear;
    -ms-origin:0%;
  }

  30% {
    opacity: 1;
    -ms-transform:rotate(410deg);
    -ms-animation-timing-function: ease-in-out;
    -ms-origin:7%;
  }

  39% {
    opacity: 1;
    -ms-transform: rotate(645deg);
    -ms-animation-timing-function: linear;
    -ms-origin:30%;
  }

  70% {
    opacity: 1;
    -ms-transform: rotate(770deg);
    -ms-animation-timing-function: ease-out;
    -ms-origin:39%;
  }

  75% {
    opacity: 1;
    -ms-transform: rotate(900deg);
    -ms-animation-timing-function: ease-out;
    -ms-origin:70%;
  }

  76% {
  opacity: 0;
    -ms-transform:rotate(900deg);
  }

  100% {
  opacity: 0;
    -ms-transform: rotate(900deg);
  }
}

@-webkit-keyframes orbit {
  0% {
    opacity: 1;
    z-index:99;
    -webkit-transform: rotate(180deg);
    -webkit-animation-timing-function: ease-out;
  }

  7% {
    opacity: 1;
    -webkit-transform: rotate(300deg);
    -webkit-animation-timing-function: linear;
    -webkit-origin:0%;
  }

  30% {
    opacity: 1;
    -webkit-transform:rotate(410deg);
    -webkit-animation-timing-function: ease-in-out;
    -webkit-origin:7%;
  }

  39% {
    opacity: 1;
    -webkit-transform: rotate(645deg);
    -webkit-animation-timing-function: linear;
    -webkit-origin:30%;
  }

  70% {
    opacity: 1;
    -webkit-transform: rotate(770deg);
    -webkit-animation-timing-function: ease-out;
    -webkit-origin:39%;
  }

  75% {
    opacity: 1;
    -webkit-transform: rotate(900deg);
    -webkit-animation-timing-function: ease-out;
    -webkit-origin:70%;
  }

  76% {
  opacity: 0;
    -webkit-transform:rotate(900deg);
  }

  100% {
  opacity: 0;
    -webkit-transform: rotate(900deg);
  }
}

@-moz-keyframes orbit {
  0% {
    opacity: 1;
    z-index:99;
    -moz-transform: rotate(180deg);
    -moz-animation-timing-function: ease-out;
  }

  7% {
    opacity: 1;
    -moz-transform: rotate(300deg);
    -moz-animation-timing-function: linear;
    -moz-origin:0%;
  }

  30% {
    opacity: 1;
    -moz-transform:rotate(410deg);
    -moz-animation-timing-function: ease-in-out;
    -moz-origin:7%;
  }

  39% {
    opacity: 1;
    -moz-transform: rotate(645deg);
    -moz-animation-timing-function: linear;
    -moz-origin:30%;
  }

  70% {
    opacity: 1;
    -moz-transform: rotate(770deg);
    -moz-animation-timing-function: ease-out;
    -moz-origin:39%;
  }

  75% {
    opacity: 1;
    -moz-transform: rotate(900deg);
    -moz-animation-timing-function: ease-out;
    -moz-origin:70%;
  }

  76% {
  opacity: 0;
    -moz-transform:rotate(900deg);
  }

  100% {
  opacity: 0;
    -moz-transform: rotate(900deg);
  }
}
</style>
<script type="text/javascript">
  function getdivajax()
  {
    $.ajax({
        url: "?r=baholash/zagr/get-baholar",
        type: "POST",
        data: ({ 
          id: $("#met").val(),
          _csrf : '<?=Yii::$app->request->getCsrfToken()?>' 
        }),
        success: function(data) {
            document.getElementById('divajax').innerHTML = data ;    // здесь задаете новое значение для инпута
        }
    });
  }

  function getloading()
  {
    document.getElementById('divajax').innerHTML = '<div class="windows8">  <div class="wBall" id="wBall_1">    <div class="wInnerBall"></div>  </div>  <div class="wBall" id="wBall_2">    <div class="wInnerBall"></div>  </div>  <div class="wBall" id="wBall_3">    <div class="wInnerBall"></div>  </div>  <div class="wBall" id="wBall_4">    <div class="wInnerBall"></div>  </div>  <div class="wBall" id="wBall_5">    <div class="wInnerBall"></div>  </div></div><h3 style="text-align:center;">Юкланмоқда...</h3>';
  }
</script>