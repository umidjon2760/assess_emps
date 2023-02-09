<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Тизимга кириш';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
        'options'=>['class'=>'login100-form validate-form p-l-55 p-r-55 p-t-178', 'enctype'=>'application/x-www-form-urlencoded'],
    ]); ?>
        <span class="login100-form-title">
            <img src="images/universal_with_logo.png" style="width:75%;">
        </span>
        
        <div class="wrap-input100 validate-input m-b-16" data-validate="Кодни киритинг">
            
            <input class="input100" type="text" name="LoginForm[yozkod]" placeholder="Почтангизга келган кодни киритинг...">
            <input type="text" name="berkod" hidden value="<?=$kod?>">
            <span class="focus-input100"></span>
        </div>
        <div class="wrap-input100 validate-input m-b-16" data-validate="Янги паролни киритинг">
            
            <input class="input100" type="password" onkeyup="EightParol();" onchange="EightParol();" required name="LoginForm[yaparol]" id="new_password" placeholder="Янги паролни киритинг...">
            <i class="fa fa-eye" id="togglePassword" onclick="newPassword();"></i>
        </div>
        <div class="wrap-input100 validate-input m-b-16" data-validate="Паролни такрорланг...">
            
            <input class="input100" type="password" id="new_password1" required name="LoginForm[tasparol]" placeholder="Паролни такрорланг...">
            <i class="fa fa-eye" id="togglePassword1" onclick="newPassword1();"></i>
            <input type="text" name="cbid" hidden value="<?=$cbid?>">
            
            <span class="focus-input100"></span>
        </div>
        
        

                    <div class="container-login100-form-btn">
                        <button type="submit" id='btn' disabled formaction="?r=site/repassword" class="login100-form-btn hov" style="background: lightgray;">
                        Саклаш
                        </button>
                    </div>
                    <br>
                    <div class="container-login100-form-btn">
                        <a href="?r=site/login" class="btn btn-success login100-form-btn">Кириш</a>
                        <!-- <button type="submit" class="login100-form-btn">
                        Кириш
                        </button> -->
                    </div>

                    
       
        </div> 
        <br>
    <?php ActiveForm::end(); ?>
<!-- 
    <div class="col-lg-offset-1" style="color:#999;">
        Агар логин ёки паролингизни билмасангиз портал оркали киринг.
    </div> -->
</div>
<style type="text/css">
    .login100-form-title
    {
        background: #EBEBEB;
        /*border-bottom: 1px solid #BD282B;*/
    }
    .login100-form-btn,.relogin
    {
        background: #BD282B;
    }
    .site-login{
        /*border: 1px solid #BD282B;*/
    }
    form i {
        position:fixed;
        left: 58%;
        bottom: 40%;
        cursor: pointer;
    }


    #togglePassword{
        position:absolute;
        left: 88%;
        bottom: 40%;
        cursor: pointer;
    }
    #togglePassword1{
        position:absolute;
        left: 88%;
        bottom: 35%;
        cursor: pointer;
    }
    .hov:hover{
        color:white;
    }
    body{
        background: white;
    }
    .content{
        background: white;
    }
    .content-header{
        background: white;
    }
    .content-wrapper{
        background: white;
    }
    h1{
        display: none;
    }
</style>
<script type="text/javascript">
    function newPassword()
    {
        const togglePassword = document.querySelector("#togglePassword");
        const new_password = document.querySelector("#new_password");
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
        const new_password1 = document.querySelector("#new_password1");
        const type = new_password1.getAttribute("type") === "password" ? "text" : "password";
        new_password1.setAttribute("type", type);
        
        // toggle the icon

        new_password1.classList.toggle("fa-eye-slash");
        const form = document.querySelector("form");
        form.addEventListener('submit', function (e) {
            e.preventDefault();
        });
    };

    function EightParol()
    {
        var new_password = document.getElementById('new_password');
        var btn = document.getElementById('btn');
        if (new_password.value.length>7) {
            btn.removeAttribute("disabled");
            btn.style.background = '#C0202A';
        }
        else{
            btn.setAttribute("disabled",true);
            btn.style.background = 'lightgray';

        }
    }
    function removedisabled()
    {
        var email = document.getElementById('email').value;
        var patt = new RegExp("@universalbank.uz");
        var res = patt.test(email);
        var btn = document.getElementById("btn");
        if (res) {
            btn.removeAttribute("disabled");
            btn.style.background = '#C0202A';
        }
        else{
            btn.setAttribute("disabled",true);
            btn.style.background = 'lightgray';
        }

    }
    function ShowPassword($id) {
      var x = document.getElementById(id);
      if (x.type === "password") {
        x.type = "text";
      } else {
        x.type = "password";
      }
    }
</script>