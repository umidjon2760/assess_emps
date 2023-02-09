<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use app\modules\baholash\models\Period;
use app\modules\baholash\models\Zagr;
//use yii\bootstrap\ActiveForm;
//use yii\captcha\Captcha;

$this->title = 'Маълумотлар юклаш';
$this->params['breadcrumbs'][] = $this->title;

$arrlist = [
    'zagruj'=>'zagruj',
    'users'=>'users',
    'relation'=>'relation',
    'rel_pokaz'=>'rel_pokaz',
    'kpi'=>'kpi'
];
// foreach ($arrlist as $key => $value) {
//     $arrlist[$key] = FactPokaz::getLastPeriod($key);
// }
?>
<div class="site-contact card">
    <div class="card-body">

        <?php
        // var_dump(Period::getPeriod());
        // echo Period::getMaxPeriod().' - '.Period::getPeriod().' - '.FactPokaz::getCountEmp();
                if(Period::getMaxPeriod()>Period::getPeriod()&&Zagr::getCountEmp()>0){
                    echo    Html::a('Архивга олиш', ['archive', 'key' => 'a'.date('d').'a'.date('Y').'a'.date('m')], [
                                'class' => 'btn btn-danger',
                                'data' => [
                                    'confirm' => 'Маълумотлар архивга олингандан кейин узгартиришлар киритиш имкони бўлмайди. Жорий давр бўйича ишлар якунланганини текширганингизни тасдиклайсиз. Архивлашни давом эттирмоқчимисиз?',
                                ],
                            ]);
                        echo "<br>";
                }
        ?>
        <?php 
            if(isset($err)){
                if($err=='Success'){
                    echo "
                        <div class='alert alert-success' role='alert'>
                          <b>".$type."</b> юклаш мувофақиятли якунланди!
                        </div>
                    ";
                }
                elseif ($err=='choosen_error') {
                    echo "
                        <div class='alert alert-danger' role='alert'>
                          Нотўғри танланди!<br>
                          ".$err."
                        </div>
                    ";
                }
                elseif ($err=='not_move') {
                    echo "
                        <div class='alert alert-danger' role='alert'>
                          Базага сақланишда хатолик!<br>
                          ".$err."
                        </div>
                    ";
                }
                elseif ($err=='not_permission') {
                    echo "
                        <div class='alert alert-danger' role='alert'>
                          Not permission!<br>
                          ".$err."
                        </div>
                    ";
                }
                else{
                    echo "
                        <div class='alert alert-danger' role='alert'>
                          Хатолик юз берди. Қайтадан уриниб кўринг.<br>
                          ".$err."
                        </div>
                    ";
                }
            }
            elseif (isset($_GET['err']) && $_GET['err']=='archived') {
                echo "
                    <div class='alert alert-success' role='alert'>
                      <b>Архив</b> юкланди!
                    </div>
                ";
            }
        ?>
        

        <p>
            Илтимос, маълумотлар базасига юкланадиган <b>(СТАНДАРТ)</b> шаклдаги файлни танланг!
        </p>
            <div class="row">
            <div class="col-lg-5">

                <?= Html::beginForm(['/baholash/zagr/upload', 'id' => 'myfile-input'], 'post', ['enctype' => 'multipart/form-data']) ?>
                <?= Html::dropDownList('list_type', 'umid', $arrlist, ['id'=>'ff'])?>
                <br><br>
                <?= Html::input('file', 'myfile', '',['class' => 'myfile-class'])?>
                <br>
                <br>
                <?= Html::submitButton('Юклаш', ['class' => 'submit btn btn-primary']) ?>
                <?= Html::endForm() ?>
            </div>
            
        </div>

   </div>
</div>




