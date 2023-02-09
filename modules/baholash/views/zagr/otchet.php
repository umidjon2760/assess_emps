<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use app\modules\baholash\models\Period;
use app\modules\baholash\models\RelationGroup;
use yii\bootstrap4\Modal;
use kartik\widgets\DatePicker;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\mj\models\JoriyEmpSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Хисоботлар';
$this->params['breadcrumbs'][] = $this->title;
// $arr = JoriyEmp::getBolims();
$periods = Period::getAllPeriods();
$groups = RelationGroup::getAll();
?>
<div class="joriy-emp-index card">
    <div class="card-body">
        <div class="row">
            <div class="col-lg-4" style="border-right: 1px solid gray;">
            <?php
            echo "<label>Хисобот V1</label>";
            echo Html::beginForm(['/baholash/zagr/otchet-v1'], 'post');
            echo Select2::widget([
                'name' => 'group',
                'data' => $groups,
                // 'data' => [],
                'options' => [
                    'placeholder' => 'Группа танланг...',
                    'multiple' => false,
                    'required' => true,
                    'class'=>'filch',
                    // 'id'=>'xodims'
                ],
                'theme' => Select2::THEME_BOOTSTRAP,
            ]);
            echo "<br>";
            echo Select2::widget([
                'name' => 'periods_v1',
                'data' => $periods,
                // 'data' => [],
                'options' => [
                    'placeholder' => 'Период танланг...',
                    'multiple' => true,
                    'required' => true,
                    'class'=>'filch',
                    // 'id'=>'xodims'
                ],
                'theme' => Select2::THEME_BOOTSTRAP,
            ]);
            echo "<br><input type='submit' value='Олиш'' class='btn btn-success btn-sm' />";
            echo Html::endForm();
            ?>
                
            </div>
            <div class="col-lg-4" style="padding-left: 1%;padding-top: 5px;border-right: 1px solid gray;">
            <?php
            echo "<label>Хисобот V2</label>";
            echo Html::beginForm(['/baholash/zagr/otchet-v2'], 'post');
            echo Select2::widget([
                'name' => 'group',
                'data' => $groups,
                // 'data' => [],
                'options' => [
                    'placeholder' => 'Группа танланг...',
                    'multiple' => false,
                    'required' => true,
                    'class'=>'filch',
                    // 'id'=>'xodims'
                ],
                'theme' => Select2::THEME_BOOTSTRAP,
            ]);
            echo "<br>";
            echo Select2::widget([
                'name' => 'periods_v2',
                'data' => $periods,
                // 'data' => [],
                'options' => [
                    'placeholder' => 'Период танланг...',
                    'multiple' => true,
                    'required' => true,
                    'class'=>'filch',
                    // 'id'=>'xodims'
                ],
                'theme' => Select2::THEME_BOOTSTRAP,
            ]);
            echo "<br><input type='submit' value='Олиш'' class='btn btn-success btn-sm' />";
            echo Html::endForm();
            ?>
            </div>
            <div class="col-lg-4" style="padding-left: 1%;padding-top: 5px;">
            <?php
            // echo "<label>Хисобот фойдаланувчи</label>";
            echo "<a href='?r=baholash/zagr/otchet-user' style='margin-top:5px;' class='btn btn-info'>Фойдаланувчилар</a><br>";
            echo "<a href='?r=baholash/zagr/otchet-relation' style='margin-top:5px;' class='btn btn-info'>Боғланиш</a><br>";
            echo "<a href='?r=baholash/zagr/otchet-relation-pokaz' style='margin-top:5px;' class='btn btn-info'>Боғланиш ID показ</a><br>";
            ?>
            </div>
        </div>
    </div>
</div>

<style type="text/css">
    #w0-filters{
        font-size: 11pt;
    }
    #w0-kvdate{
        width:40%;
    }
</style>