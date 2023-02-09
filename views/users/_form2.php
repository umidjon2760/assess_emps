<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Users */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= Html::label('Эски пароль', 'OLD_PASSWORD', ['class' => 'control-label']) ?>
    <?= Html::input('PASSWORD', 'OLD_PASSWORD', '', ['class' => 'form-control','id'=>'OLD_PASSWORD','required'=>true]) ?>
    <i class="fa fa-eye" onclick="newPassword2();" id="togglePassword2"></i>
    <br>
    
    <?= $form->field($model, 'PASSWORD')->passwordInput(['maxlength' => true,'required'=>true, 'value'=>'','onkeyup'=>'EightParol();','onchange'=>'EightParol();']) ?>
    <i class="fa fa-eye" id="togglePassword" onclick="newPassword();"></i>

    <?= Html::label('Паролни такрорланг', 'CONFIRM_PASSWORD', ['class' => 'control-label']) ?>
    <?= Html::input('PASSWORD', 'CONFIRM_PASSWORD', '', ['class' => 'form-control','id'=>'CONFIRM_PASSWORD','required'=>true]) ?>
    <i class="fa fa-eye" onclick="newPassword1();" id="togglePassword1"></i>
	<br>

    <div class="form-group">
        <!-- <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?> -->
        <button type="submit" id="btn" disabled style="background: lightgray;" class="btn btn-success">Сақлаш</button>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script type="text/javascript">
    function EightParol()
    {
        var userspassword = document.getElementById('users-password');
        var btn = document.getElementById('btn');
        if (userspassword.value.length>7) {
            btn.removeAttribute("disabled");
            btn.style.background = 'green';
        }
        else{
            btn.setAttribute("disabled",true);
            btn.style.background = 'lightgray';

        }
    }
    function newPassword2()
    {
        const togglePassword = document.querySelector("#togglePassword2");
        const new_password = document.querySelector("#OLD_PASSWORD");
        const type = new_password.getAttribute("type") === "password" ? "text" : "password";
        new_password.setAttribute("type", type);
        
        // toggle the icon

        new_password.classList.toggle("fa-eye-slash");
        const form = document.querySelector("form");
        form.addEventListener('submit', function (e) {
            e.preventDefault();
        });
    }
    function newPassword()
    {
        const togglePassword = document.querySelector("#togglePassword");
        const new_password = document.querySelector("#users-password");
        const type = new_password.getAttribute("type") === "password" ? "text" : "password";
        new_password.setAttribute("type", type);
        
        // toggle the icon

        new_password.classList.toggle("fa-eye-slash");
        const form = document.querySelector("form");
        form.addEventListener('submit', function (e) {
            e.preventDefault();
        });
    }

    function newPassword1()
    {
        const togglePassword1 = document.querySelector("#togglePassword1");
        const new_password1 = document.querySelector("#CONFIRM_PASSWORD");
        const type = new_password1.getAttribute("type") === "password" ? "text" : "password";
        new_password1.setAttribute("type", type);
        
        // toggle the icon

        new_password1.classList.toggle("fa-eye-slash");
        const form = document.querySelector("form");
        form.addEventListener('submit', function (e) {
            e.preventDefault();
        });
    };
</script>
<style type="text/css">
    #togglePassword{
        position:absolute;
        left: 90%;
        bottom: 51%;
        cursor: pointer;
    }
    #togglePassword1{
        position:absolute;
        left: 90%;
        bottom: 24%;
        cursor: pointer;
    }
    #togglePassword2{
        position:absolute;
        left: 90%;
        bottom: 82%;
        cursor: pointer;
    }
</style>