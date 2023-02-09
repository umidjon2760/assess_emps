<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\baholash\models\KpiCard */

$this->title = $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Руйхат', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="kpi-card-view card">
    <div class="card-body">

    <p>
        <?= Html::a('Узгартириш', ['update', 'id' => $model->ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Учириш', ['delete', 'id' => $model->ID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Ишончингиз комилми?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'ID',
            'PERIOD',
            'INPS',
            'MFO',
            'LOCAL_CODE',
            'CODE_DOLJ',
            'KPI_METHOD',
            'TABNUM',
            'ORD',
            'CRITERIY_NAME',
            'CRITERIY_ALGORITHM',
            'MIN_VALUE',
            'AVG_VALUE',
            'MAX_VALUE',
            'VES',
            'PLAN',
            'FACT',
            'BAJARILISH',
            'IVSH',
            'CRITERIY_KPI',
        ],
    ]) ?>
    </div>
</div>
