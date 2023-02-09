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
            if (isset($err)) {
                if ($err=='No') {
                    echo "<p style='padding-bottom:10px;font-style:italic;color:red;'>Бундай логинда email мавжуд эмас!<p>";
                }
                elseif ($err=='xato') {
                    echo "<p style='padding-bottom:10px;font-style:italic;color:red;'>Код нотугри киритилди!<p>";
                }
                elseif($err=='parxato'){
                    echo "<p style='padding-bottom:10px;font-style:italic;color:red;'>Тасдиклаш пароли нотугри!!<p>";
                }
                elseif ($err=='dno') {
                    echo "<p style='padding-bottom:10px;font-style:italic;color:red;'>Бу фойдаланувчидаги почта манзили Hamkorbank Domino тизимида мавжуд эмас!<p>";
                }
                else{
                    echo "";
                }
            }
        ?>
        <div class="wrap-input100 validate-input m-b-16" data-validate="ЦБИДни киритинг">
            <input class="input100" type="text" name="LoginForm[username]" placeholder="Логинингизни киритинг...">
            <input type="text" name="kod" hidden value="<?=$kod?>">
            <span class="focus-input100"></span>
        </div>
        
        

                    <div class="container-login100-form-btn">
                        <button type="submit" class="login100-form-btn" formaction="?r=site/repassword">
                        Паролни тиклаш
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
</style>