<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Users */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-form">

    <?php $form = ActiveForm::begin(); ?>

    
    <?php
        echo "<p style='font-weight:bold;font-size:20pt;'>Базадаги почтангиз : ".$model->EMAIL."<br></p>";
    ?>
    <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'value'=>'@universalbank.uz','onkeyup'=>'removedisabled();']) ?>

	<br>

    <div class="form-group"> 
        <p style="padding: 6px;border: 1px solid black;width: 103px;border-radius: 5px;background-color: white;text-align: center;" id="pnone" >Сохранить</p>
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success dnone','id'=>'buttn']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
<style type="text/css">
    .dnone{
        display:none;
    }
    .pnone{
        display:none;
    }
</style>
<script type="text/javascript">
    function removedisabled()
    {
        // var email = document.getElementById('users-email').value;
        // var patt = new RegExp("@universalbank.uz");
        // var res = patt.test(email);

        let email = document.getElementById('users-email').value;
        let result = email.substr(-17);

        if (result=='@universalbank.uz') {
            var element = document.getElementById("buttn");
            element.classList.remove("dnone");
            var element1 = document.getElementById("pnone");
            element1.classList.add("pnone");
        }
        else{
            var element = document.getElementById("buttn");
            element.classList.add("dnone");
            var element1 = document.getElementById("pnone");
            element1.classList.remove("pnone");
        }

    }
</script>
