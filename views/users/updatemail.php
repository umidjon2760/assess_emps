<?php

use yii\helpers\Html;
use app\models\Emp;
use app\models\Users;

/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = 'Изменение почта для '.Users::getName($model->LOGIN);
$this->params['breadcrumbs'][] = ['label' => Users::getName($model->LOGIN), 'url' => ['view', 'id' => $model->LOGIN]];
$this->params['breadcrumbs'][] = 'Изменение почта';
?>
<div class="users-update">
<?php
if($err!=''&&$err!='success'&&$err!='not'){
?>
<div class="panel panel-danger">
   <div class="panel-heading"><?=$err?></div>
</div>
<?php
}
elseif ($err=='not') {
?>
	<div class="panel panel-success">
	   <div class="panel-heading"><p style="color: orange;font-size:20pt;">Почта сақланмади! Почтангизда "@universalbank.uz" ишлатилмаган! Илтимос Банкдаги почтангизни киритинг!</p></div>
	</div>
<?php
}
elseif($err=='success'){
?>
<div class="panel panel-success">
   <div class="panel-heading"><p style="color: green;font-size:20pt;">Email муваффаққиятли сақланди.</p></div>
</div>
<?php
}
?>

    <?= $this->render('_formemail', [
        'model' => $model,
    ]) ?>

</div>
