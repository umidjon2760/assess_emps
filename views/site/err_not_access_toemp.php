<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = 'Not found';
$message = 'Ушбу сахифадаги маълумотлар сиз учун ёпиқ. Администраторга хабар беринг';
?>
<div class="site-error card">
    <div class="card-body">

        <div class="alert alert-danger">
            <?= nl2br(Html::encode($message)) ?>
        </div>
    </div>
</div>
