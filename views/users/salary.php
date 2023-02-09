<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Period;

/* @var $this yii\web\View */
/* @var $model app\models\Users */
$period = date('d.m.Y',strtotime($period));
$act_class = date('n',strtotime($period));



for ($i=1; $i < 13; $i++) { 
    $d = '01.';
    
    if($i<10){
        $m = '0'.$i.'.';
    }
    else{
        $m = $i.'.';    
    }
    if($i<date('n')){
        $y = date('Y');
    }
    else{
        $y = date('Y', strtotime("-1 year"));
    }

    $period1 = $d.$m.$y;
    
    if($act_class==$i){
        $this->params['breadcrumbs'][] = ['label' => Period::getMonthName($i), 'url' => ['salary', 'period' => $period1], 'class' => 'active_breadcrumb'];   
    }   
    else{
        $this->params['breadcrumbs'][] = ['label' => Period::getMonthName($i), 'url' => ['salary', 'period' => $period1]];       
    }
    
}
$this->title = $period.' учун иш хақи';
$arr_color = [
    '---'=>'primary',
    '100'=>'success',
    '101'=>'default',
    '102'=>'default',
    '733'=>'warning',
    '133'=>'danger',
    '178'=>'success',
    '174'=>'warning',
    '216'=>'default',
    '501'=>'danger',
    '502'=>'danger',
    '503'=>'danger',
    '600'=>'success',
    '740'=>'success',
    '741'=>'warning',
    '744'=>'success',
    '745'=>'warning',
    '730'=>'success',
    '160'=>'success',
    '163'=>'warning',
    '777'=>'success',
    '184'=>'success',
];
$arr_symbol = [
    '---'=>'fas fa-money-bill-alt',
    '100'=>'fas fa-money-bill-wave',
    '101'=>'fas fa-calendar-times',
    '102'=>'fas fa-home',
    '733'=>'fas fa-home',
    '133'=>'fas fa-carrot',
    '174'=>'fas fa-utensils',
    '178'=>'fas fa-credit-card',
    '216'=>'fas fa-head-side-mask',
    '501'=>'fas fa-landmark',
    '502'=>'fas fa-landmark',
    '503'=>'fas fa-landmark',
    '600'=>'fas fa-hand-holding-usd',
    '741'=>'fas fa-drumstick-bite',
    '777'=>'fas fa-plus',
    '730'=>'fas fa-piggy-bank',
    '740'=>'fas fa-plus',
    '744'=>'fas fa-plane-departure',
    '160'=>'fas fa-plane-departure',
    '745'=>'fas fa-umbrella-beach',
    '163'=>'fas fa-umbrella-beach',
    '184'=>'fas fa-stopwatch',
];

?>
<div class="users-view">


            <div class="card">
              <div class="card-header border-0">
                <h3 class="card-title">Иш хақи картаси</h3>
                <div class="card-tools">
                  <!-- <a href="#" class="btn btn-tool btn-sm">
                    <i class="fas fa-download"></i>
                  </a> -->
                  <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <a href="#" class="btn btn-tool btn-sm">
                    <i class="fas fa-bars"></i>
                  </a>
                </div>
              </div>
              <div class="card-body table-responsive p-1">
                <table class="table table-striped table-valign-middle">
                  <thead>
                  <tr>
                    <th>Порядок</th>
                    <th>Название</th>
                    <th>Сумма</th>
                  </tr>
                  </thead>
                  <tbody>
<?php
$i = 1;
    foreach ($salary as $key) {
        echo "<tr>";
            echo "<td>";
            echo $i;
            echo "</td>";
            echo "<td>";
            echo $key['PAY_NAME'];
            echo "</td>";
            echo "<td>";
            if(isset($arr_color[$key['PAY_ID']])){
                echo '<small class="text-'.$arr_color[$key['PAY_ID']].' mr-2">
                        <i class="'.$arr_symbol[$key['PAY_ID']].'"></i>
                  </small>';
            }
            else{
                echo '<small class="text-default mr-2">
                        <i class="fas fa-money-bill-wave"></i>
                  </small>';
            }
            
            echo $key['SUM_PAY'];
            echo "</td>";
        echo "</tr>";
        $i++;
    }   

?>                  
                  </tbody>
                </table>
              </div>
            </div>


</div>
