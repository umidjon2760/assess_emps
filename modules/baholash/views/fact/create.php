<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\baholash\models\Fact */

$this->title = 'Янги';
$this->params['breadcrumbs'][] = ['label' => 'Руйхат', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fact-create card">
	<div class="card-body">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
	</div>
</div>
