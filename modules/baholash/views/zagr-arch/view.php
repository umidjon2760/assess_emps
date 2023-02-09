<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\baholash\models\ZagrArch */

$this->title = $model->NAME;
$this->params['breadcrumbs'][] = ['label' => 'Руйхат', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="zagr-arch-view card">
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
            'CBID',
            'INPS',
            'MFO',
            'LOCAL_CODE',
            'NAME',
            'BOLIM_CODE',
            'BOLIM_NAME',
            'CODE_DOLJ',
            'LAVOZIM_NAME',
            'TABEL',
            'PERIOD',
        ],
    ]) ?>
    </div>
</div>
