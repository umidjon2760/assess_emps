<head>
    <title>Тизимга кириш</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->  
    <link rel="icon" type="image/png" href="./login/images/icons/favicon.ico"/>
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="./login/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="./login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="./login/vendor/animate/animate.css">
<!--===============================================================================================-->  
    <link rel="stylesheet" type="text/css" href="./login/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="./login/vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="./login/vendor/select2/select2.min.css">
<!--===============================================================================================-->  
    <link rel="stylesheet" type="text/css" href="./login/vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="./login/css/util.css">
    <link rel="stylesheet" type="text/css" href="./login/css/main.css">
<!--===============================================================================================-->
</head>
<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\Users;

$this->title = 'Паролни ўзгартириш';
?>

<div class="site-login">
    <h2 style="margin-left: 32%;"><?php echo Users::getName(Yii::$app->user->ID)?></h2>
    <h2 style="margin-left: 34%;">Паролингизни ўзгартиринг!</h2>
    <h5 style="text-align: center; font-style:italic;color:red;margin-left: 34%; width: 430px;">Логинингиз билан паролингиз ўзаро фарқ қилиш керак хамда камида 8 та белгидан иборат бўлиши керак!</h5>
        <?php
            if (isset($err)) {
                echo "<p style='font-size:18pt;text-align: center;margin-left: -130px;font-style:italic;color:red;'><b>".$err."</b><p>";
                
            }
        ?>

    <?php $form = ActiveForm::begin([
        'action'=>['change/changeparol'],
        'method'=>'post',
        'id' => 'login-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
        'options'=>['class'=>'login100-form validate-form p-l-55 p-r-55 p-t-178', 'enctype'=>'application/x-www-form-urlencoded'],
    ]); ?>
        <span class="login100-form-title offset-4" style="width: 453px;margin-top: 20px; background: #C0202A;border-top-right-radius: 30px;border-top-left-radius: 30px;box-shadow: rgba(0, 0, 0, 0.06) 0px 2px 4px 0px inset;">
            UNIVERSALBANK
        </span>
        <div class=" validate-input m-b-16 offset-4" style="width: 453px;border-right: 1px solid #C4C4CB;border-left: 1px solid #C4C4CB;margin-top: -34px;right: 18px; padding: 30px 35px;" data-validate="ЦБИДни киритинг">
            <label>Эски пароль</label>
            <input class="form-control" type="text" style="margin-bottom: 13px;" id="old_password" required name="old_password" value="<?=Yii::$app->user->ID?>"  placeholder="Эски паролингизни киритинг...">
            <label>Янги пароль</label>
            <input class="form-control" type="password"  style="margin-bottom: 13px;" onkeyup="EightParol();" onchange="EightParol();" id="new_password" required name="new_password" placeholder="Янги паролингизни киритинг..."><i class="fa fa-eye" id="togglePassword" onclick="newPassword();"></i>
            <label>Янги паролни қайтадан киритинг</label>
            <input class="form-control" type="password" style="margin-bottom: 13px;" id="new_password1" required  name="new_password1" placeholder="Янги паролни қайтадан киритинг..."><i class="fa fa-eye" id="togglePassword1" onclick="newPassword1();"></i>
            <label>Почта</label>
            <input class="form-control" type="email" style="margin-bottom: 13px;" value="<?=Yii::$app->user->identity->EMAIL?>" onkeyup="EightParol();" id="email" required  name="email" placeholder="example@universalbank.uz" placeholder="Почтангизни киритинг..." >
            
        </div>
        
        

                    <div class=" offset-4" style=" ;width: 453px;right: 18px;position: relative;box-shadow: rgba(50, 50, 93, 0.25) 0px 30px 60px -12px, rgba(0, 0, 0, 0.3) 0px 18px 36px -18px;bottom: 57px;padding: 30px 35px;border-right: 1px solid #C4C4CB;border-left: 1px solid #C4C4CB;border-bottom: 1px solid #C4C4CB;  border-bottom-right-radius: 30px;border-bottom-left-radius: 30px; ">
                        <button type="submit" id="btn" disabled style="background: lightgray;" class="login100-form-btn hov">
                        Сақлаш
                        </button><br>
                        <a href="?r=change/logout" style="background: #C0202A;" class="login100-form-btn hov">Чиқиш</a>
                    </div>
                    <br>

                    
       
        </div> 
        <br>
    <?php ActiveForm::end(); ?>
<!-- 
    <div class="col-lg-offset-1" style="color:#999;">
        Агар логин ёки паролингизни билмасангиз портал оркали киринг.
    </div> -->
</div>
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
        let email = document.getElementById('email').value;
        let result = email.substr(-17);
        if (new_password.value.length>7&&result=='@universalbank.uz') {
            btn.removeAttribute("disabled");
            btn.style.background = '#C0202A';
        }
        else{
            btn.setAttribute("disabled",true);
            btn.style.background = 'lightgray';

        }
    }
    // function removedisabled()
    // {
    //     // var email = document.getElementById('email').value;
    //     // var patt = new RegExp("@universalbank.uz");
    //     // var res = patt.test(email);

    //     let email = document.getElementById('email').value;
    //     let result = email.substr(-17);
    //     var btn = document.getElementById("btn");
    //     if (result=='@universalbank.uz') {
    //         btn.removeAttribute("disabled");
    //         btn.style.background = '#C0202A';
    //     }
    //     else{
    //         btn.setAttribute("disabled",true);
    //         btn.style.background = 'lightgray';
    //     }

    // }
    function ShowPassword($id) {
      var x = document.getElementById(id);
      if (x.type === "password") {
        x.type = "text";
      } else {
        x.type = "password";
      }
    }
</script>
<style type="text/css">
    #togglePassword{
        position:absolute;
        left: 86%;
        bottom: 56%;
        cursor: pointer;
    }
    #togglePassword1{
        position:absolute;
        left: 86%;
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
<!--===============================================================================================-->
    <script src="./login/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
    <script src="./login/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
    <script src="./login/vendor/bootstrap/js/popper.js"></script>
    <script src="./login/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
    <script src="./login/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
    <script src="./login/vendor/daterangepicker/moment.min.js"></script>
    <script src="./login/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
    <script src="./login/vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
    <script src="./login/js/main.js"></script>
