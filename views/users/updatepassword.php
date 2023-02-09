<?php

use yii\helpers\Html;
use app\models\Users;
/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = 'Пароль ўзгартириш';
$this->params['breadcrumbs'][] = ['label' => Users::getName($model->LOGIN), 'url' => ['view', 'id' => $model->LOGIN]];
$this->params['breadcrumbs'][] = 'Пароль ўзгартириш';
?>
<div class="users-update">
<?php
if($err!=''&&$err!='success'){
?>
<div class="panel panel-danger">
   <div class="panel-heading"><?=$err?></div>
</div>
<?php
}
elseif($err=='success'){
?>
<div class="panel panel-success">
   <div class="panel-heading">Пароль муваффаққиятли сақланди.</div>
</div>
<?php
}
?>
	<div class="col-lg-3 ">
	    <?= $this->render('_form2', [
	        'model' => $model,
	    ]) ?>
		
	</div>

</div>
