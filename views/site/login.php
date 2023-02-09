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
        <?php
        //var_dump($_GET);die;
            if (isset($_GET['err'])) {
                //var_dump($err);die;
                if ($_GET['err']=='success') {
                    echo "<p style='font-weight: bold;margin-bottom: 20px;'>Парол янгиланди!</p>";
                }
                if ($_GET['err']=='warn') {
                    echo "<p style='font-weight: bold;margin-bottom: 20px;'>Парол янгиланишда хатолик!</p>";
                }
            }
        ?>
        <div class="wrap-input100 validate-input m-b-16" data-validate="ЦБИДни киритинг">
            
            <input class="input100 logpar" type="text" name="LoginForm[username]" placeholder="Логин">
            <span class="focus-input100"></span>
        </div>
        <div class="wrap-input100 logpar validate-input" data-validate = "Паролингизни киритинг">
            <input class="input100" type="password" id="password" name="LoginForm[password]" placeholder="Пароль">
            
        </div><br>

                    <div class="container-login100-form-btn">
                        <button type="submit" class="login100-form-btn">
                            Тизимга кириш
                        </button>
                    </div>
        <div class="text-right p-t-13 p-b-23">
                        
                        <a href="?r=site/relogin" class="relogin btn btn-danger btn-sm" style="padding: 5px 10px;border-radius: 20px;">
                            Логин / Пароль
                            <span class="">
                            эсингиздан чиқдими?
                        </span>
                        </a>

                        
                    </div>

                 
       

    <?php ActiveForm::end(); ?>

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
</style>