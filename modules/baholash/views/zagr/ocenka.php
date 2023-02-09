<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use app\modules\baholash\models\Zagr;
use app\models\KpiPokaz;
use app\modules\baholash\models\Session;
use app\modules\baholash\models\Fact;

/* @var $this yii\web\View */
/* @var $searchModel app\models\KpiFactSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
if ($gr=='only_360') {
    $link = 'baho-all';
}
else{
    $link = 'baho-kpi';
}
$this->title = Zagr::getName($_GET['id']);
$this->params['breadcrumbs'][] = ['label' => 'Руйхат', 'url' => [$link]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kpi-fact-index">

<form action="?r=baholash/zagr/saveocenka" method="post" id='second_form'>
    <input type="hidden" name="_csrf" value="B2K4AsSdNFWwukWrmpPfpusRylyZqcqHL0Ks6joYQox0Kt8xosxXPfXTEtu3opyUnnj7Fv_L_NNEJ869WC0KzQ==">
    <input type="hidden" name="group" value="<?=$gr;?>">
<table class='table table-bordered table-striped table-hover'>
<tr>
    <th>№</th>
    <th>Критерия</th>
    <th>Бахо</th>
    <th>Изох</th>
</tr>
<?php 
$i = 1;
foreach ($rows as $key) {
    echo "
    <tr>
        <td>".$i."</td>
        <td>".Zagr::getPokazName($key->POKAZ_CODE)."</td>
        <td>".Fact::getValueList($key->ID,$gr)."</td>
        <td>".Fact::geIzoh($key->ID,$gr)."</td>
    </tr>";
    $i++;
}
?>

</table>
<table border="1" cellspacing="0">
    <tr>
        <td style="padding: 5px;text-align: center;">0</td>
        <td style="padding: 5px;text-align: center;">Жуда ёмон</td>
    </tr>
    <tr>
        <td style="padding: 5px;text-align: center;">1 - 50</td>
        <td style="padding: 5px;text-align: center;">Қониқарсиз</td>
    </tr>
    <tr>
        <td style="padding: 5px;text-align: center;">51 - 75</td>
        <td style="padding: 5px;text-align: center;">Қониқарли</td>
    </tr>
    <tr>
        <td style="padding: 5px;text-align: center;">76 - 100</td>
        <td style="padding: 5px;text-align: center;">Жуда яхши</td>
    </tr>
    <tr>
        <td style="padding: 5px;text-align: center;">> 100</td>
        <td style="padding: 5px;text-align: center;">Жуда аъло</td>
    </tr>
</table>

<p id="ogox">Ходим бахоси 100%дан фарк килса "ИЗОХ(Комментарий)" тулдириш зарур бўлади.</p>
<?php
$session = Session::getSessionMe($gr);
if($session==1){
    echo "<input id='submitter' type='submit' name='submit' value='Сохранить' class='btn btn-primary' />";
}
else{
    $id=Yii::$app->user->ID;
    
    echo "<a class='btn btn-primary' href='?r=baholash/zagr/".$link."'>Кайтиш</a>";
}
?>

</form>








<script type="text/javascript">


function checkParams(id){
    var v1 = document.getElementById("val"+id).value;
    if(v1!=100){
       document.getElementById("izoh"+id).setAttribute('required','required');
    }
    else{
        document.getElementById("izoh"+id).removeAttribute('required');
    }
}


</script>


<style type="text/css">
    p#ogox{
        font-size: 24px;
        color:red;
        font-weight: bold;
    }
</style>



<?php
/*
 document.getElementById("izoh"+id).setAttribute('required');

<form action="?r=kpi-fact/saveocenka" method="get">
    <input type="hidden" name="nuvid" value="<?=$_GET['id']?>">
  GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'ID',
            //'LOV_ID',
            'NUV_ID'=>[
                'attribute'=>'NUV_ID',
                'value' => function ($data) {                    
                    return Hr::getFioByTabnum($data->NUV_ID);
                }
            ],
            'KPI_CODE'=>[
                'attribute'=>'KPI_CODE',
                'value' => function ($data) {                    
                    return KpiPokaz::getName($data->KPI_CODE);
                }
            ],
            'VALUE'=>[
                'attribute'=>'VALUE',
                'format'=>'raw',
                'value' => function ($data) {                    
                    return KpiFact::getValueList($data->ID);
                }
            ],
            'IZOH'=>[
                'attribute'=>'IZOH',
                'format'=>'raw',
                'value' => function ($data) {                    
                    return KpiFact::geIzoh($data->ID);
                }
            ],
            //'PERIOD',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); 
    <input type="submit" value="Сохранить" class="btn btn-primary" />
</form>

*/
?>
</div>