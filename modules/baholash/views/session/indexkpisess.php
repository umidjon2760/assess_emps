<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\modules\baholash\models\Session;
use app\modules\baholash\models\Period;
use app\modules\baholash\models\Filials;
/* @var $this yii\web\View */
/* @var $searchModel app\models\SessionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Сессиялар (KPI)';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="session-index card">
<div class="card-body">

    <?php
    if (isset($_GET['Hujuiku765d5ddQHu3nds'])&&$_GET['Hujuiku765d5ddQHu3nds']=='dwdcdfew') {
        echo "<p style='color:green;font-weight:bold;'>Жўнатилди!</p>";
    }
    ?>    
    <p>
        <?= Html::a('Огохлантириш', ['zagr/send-message-for-session','BuBIU78rvu7CF876cvd8ws7nvgdsa'=>'only_kpi'], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('Янги сессия очиш', ['openalltoone','group'=>'only_kpi'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Бахолашни очиш', ['backalltosessionnokpifact','session_id'=>'1','group'=>'only_kpi'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Бахолашни ёпиш', ['backalltosessionnokpifact','session_id'=>'2','group'=>'only_kpi'], ['class' => 'btn btn-danger']) ?>
        <?= Html::a('Check session', ['obnovit-sessii','group'=>'only_kpi'], ['class' => 'btn btn-danger','data-confirm'=>'Sessiyalarni qaytadan tekshirasizmi?']) ?>
    </p>

<?php

?>
<h2>Филиаллар</h2>
<table class='table table-bordered table-striped table-hover'>
<tr>
    <th>№</th>
    <th><a href='?r=baholash/session/fil-session&sort=mfo'>МФО</a></th>
    <th><a href='?r=baholash/session/fil-session&sort=local_code'>Локал код</a></th>
    <th>Филиал</th>
    <th><a href='?r=baholash/session/fil-session&sort=progress'>Прогресс</a></th>
    <th>Куриш</th>
</tr>
<?php 
if(isset($_GET['sort'])){
if($_GET['sort']=='progress'){
    $query = "select f.*
              , (select count(session_id) res from assess_session where period = '".Period::getPeriod()."' and mfo = f.mfo and session_id=2) progress
              from assess_filials f
              order by progress
    ";
}
else{
    $query = "select * from assess_filials order by mfo";
}
}
else{
$query = "select * from assess_filials order by mfo";
}

$rows = Yii::$app->db->createCommand($query)->queryAll();
$i = 1;
foreach ($rows as $key) {
    echo "
    <tr>
        <td>".$i."</td>
        <td>".$key['MFO']."</td>
        <td>".$key['LOCAL_CODE']."</td>
        <td>".$key['NAME']."</td>
        <td class='".Session::getclassForFilial(Session::getSessionForFilial($key['LOCAL_CODE'],'only_kpi'))."'>".Session::getSessionForFilial($key['LOCAL_CODE'],'only_kpi')."</td>
        <td><a href='?r=baholash/session/fil-view&code=".$key['LOCAL_CODE']."&group=only_kpi'>Кўриш</a></td>
    </tr>";
    $i++;
}
?>

</table>

</div>
</div>


<style type="text/css">
    .mynull{
        background-color: #d43f3a;
        color: white;
    }
    .myfull{
        background-color: #5cb85c;
        color: white;
    }
    .mypart{
        background-color: orange;
        color: white;
    }
</style>