<?php



use yii\helpers\Html;
use kartik\grid\GridView;
use app\modules\baholash\models\Session;
use app\modules\baholash\models\Fact;


/* @var $this yii\web\View 1*/
/* @var $searchModel app\models\FactSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'Бахоланадиган ходимлар';
$this->params['breadcrumbs'][] = $this->title;
//$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index']];
$session = Session::getSessionMe('only_kpi');

if($session>0&&$session<5){
    $this->title = 'Бахоланадиган ходимлар';

?>
<div class="kpi-fact-index">

   


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            'NAME',
            'CODE_DOLJ',
            'BOLIM_NAME',
            'LAVOZIM_NAME',
            [
                'header' => 'Оценки', 
                'format' => 'raw', 
                
                'contentOptions' => function ($data) {
                    return  Fact::getClass($data->INPS);
                },

                'value' => function ($data) {
                        return Fact::getLink($data->INPS);
                        //return "<a href='?r=kpi-fact/ocenka&id=".$data->ID."'>".'Оценить'.$session."</a>";
                    
                }
            ],
        ],
    ]); ?>
</div>

<?php

$alert = Fact::getMyInfoFull();
if($alert==1&&$session==1){
echo '<p id="ogox">Ходимларни бахолаб булганингиздан сунг илтимос "Бахолашни якунлаш" тугмасини босинг.';
echo Html::a(
    'Бахолашни якунлаш',
    ['/baholash/zagr/closemysession'],
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