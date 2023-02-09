<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\baholash\models\AccessMatrix;
use app\models\Users;
use yii\widgets\MaskedInput;
use yii\bootstrap4\Modal;
/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = $model->NAME;
if (AccessMatrix::getAccess('admin',Yii::$app->user->ID)){
    $this->params['breadcrumbs'][] = ['label' => 'Руйхат', 'url' => ['index']];
}
if (AccessMatrix::getAccess('co_user',Yii::$app->user->ID))
{
    $this->params['breadcrumbs'][] = ['label' => 'Руйхат', 'url' => ['my-index']];
}
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

// Yii::$app->mailer->compose()->setFrom(['u.ahmadjonov@hamkorbank.uz'=>'Жорий вазифа'])->setTo('u.ahmadjonov@hamkorbank.uz')->setSubject('TEST')->setHtmlBody('<p style="font-size:16pt; color:green;font-family:Century Gothic;"><b>TEST</b></p>')->send();
?>
<div class="users-view card">
    <div class="card-body">

    
        <?php
        if ($model->LOGIN==Yii::$app->user->ID) {
            echo Html::a('Паролни ўзгартириш', ['updatepassword', 'id' => $model->LOGIN], ['class' => 'btn btn-primary']).' ';
        } 
        echo Html::a('Почтани (e-mail) ўзгартириш', ['updatemail', 'id' => $model->LOGIN], ['class' => 'btn btn-primary']);
        ?>
        <?php
        if (AccessMatrix::getAccess('admin',Yii::$app->user->ID)) {
            echo Html::a('Reset password', ['reset-password','id'=>$model->LOGIN], ['class' => 'btn btn-danger','data-confirm'=>'Эски паролни ИНПС рақамга ростдан хам ўзгартирмоқчимисиз?']);
        }
        ?>
        <?php
        if (AccessMatrix::getAccess('admin',Yii::$app->user->ID)) {
            Modal::begin([
              'title' => "<p style='text-align:center;'>Пароль янгилаш</p>",
              'id'=>'your-modall',
              // 'size'=>'modal-lg',
            ]);
            echo "<div id='userpass'>";
            echo "<input type='text' id='newpass' class='form-control' onkeyup='EightParol();' onchange='EightParol();'><br>";
            echo "<button class='btn btn-success btn-sm' id='btn' disabled onclick='save_password();'>Саклаш</button>";
            echo "</div>";
            Modal::end();
            echo Html::button(
               'Пароль янгилаш', [
                    'class'=>'btn btn-info ',
                    // 'id' => $data->ID,
                    'data-toggle' => 'modal',
                    'title' => 'Кайта ишлаш',
                    'data-target' => '#your-modall',
                ]
            );
        }
        ?>
    <br><br>
    <table class="table table-bordered table-striped">
    <tr><td><b>ФИО</b></td><td colspan="2"><?=$model->NAME?></td></tr>
    <tr><td style="width:15%; "><b>Логин</b></td><td colspan="2"><?=$model->LOGIN?></td></tr>

    <tr><td><b>Email</b></td><td colspan="2"><?=$model->EMAIL?></td></tr>
    <tr><td><b>МФО</b></td><td colspan="2"><?=$model->MFO?></td></tr>
    <tr><td><b>Локал коди</b></td><td colspan="2"><?=$model->LOCAL_CODE?></td></tr>
    <tr><td><b>Лавозим коди</b></td><td colspan="2"><?=$model->CODE_DOLJ?></td></tr>
    <tr><td><b>Бўлим номи</b></td><td colspan="2"><?=$model->BOLIM_NAME?></td></tr>
    <tr><td><b>Лавозим номи</b></td><td colspan="2"><?=$model->LAVOZIM_NAME?></td></tr>
    <tr><td><b>Телефон рақам</b></td><td style="width:15%; "><?php
                echo '+998 '.MaskedInput::widget([
                    'name' => 'mobil',
                    'mask' => '99-999-99-99',
                    'value'=>$model->PHONE_NUMBER,
                    'options'=>['required'=>true,'class'=>'','id'=>'phone','style'=>"border:none;border-bottom:1px solid black;"]
                ]);
                ?></td><td><button onclick="save_phone(<?=$model->LOGIN;?>);" class="btn btn-info btn-sm">Сақлаш</button></td></tr>
    </table><br>
    <?php
    if(!$is_couser||Yii::$app->user->ID==$model->LOGIN)
    {
    ?>
    <table class="table table-bordered">
        <tr>
            <td style="width: 30%;">
                <?php
                echo "<label>Расм юклаш</label>";
                echo Html::beginForm(['/baholash/zagr/img-upload'], 'post',['enctype' => 'multipart/form-data']);
                echo Html::input('file', 'myfile', '',['class' => 'myfile-class','id'=>'rasm','required'=>'required','accept'=>'image/*']);
                echo Html::input('hidden', 'inps', $model->LOGIN,['class' => 'myfile-class','id'=>'inps']);
                echo "<br>";
                echo "<br><input type='submit' value='Юклаш'' class='btn btn-success btn-sm' />";
                echo Html::endForm();
                ?>
            </td>
            <td>
                <img width="100" height="125" src="<?=Users::getRasm($model->LOGIN)?>">
                <a href="?r=users/delete-image&id=<?=$model->LOGIN?>" data-confirm="Расмингизни ростдан хам ўчирмоқчимисиз?">Ўчириш</a>
            </td>
        </tr>
    </table>
    <?php
    }
    ?>
    
    </div>
</div>
<script type="text/javascript">
    var uploadField = document.getElementById("rasm");
    uploadField.onchange = function() {
        if(this.files[0].size > 524288){
           alert("0,5 МБ дан кичик файл юклашингиз керак.");
           this.value = "";
        };
    };
    function save_phone(cbid)
    {
        var phone = document.getElementById('phone').value;
        var count = phone.split("_").length - 1;
        if (phone.length>0) {
            var last = phone.length - count;
        }
        else{
            var last = 9;
        }
        // alert(last);
        if (last!=12) {
            alert('Телефон рақамни тўлиқ киритинг!!!');
        }
        else{
          $.ajax({
              url: "?r=users/save-phone",
              type: "POST",
              data: ({ 
                cbid: cbid,
                phone: phone,
                _csrf : '<?=Yii::$app->request->getCsrfToken()?>' 
              }),
              success: function(data) {
                  alert(data) ;    // здесь задаете новое значение для инпута
              }
          });
        }

    }
    function save_password()
    {

        var cbid = <?=$model->LOGIN?>;
        var password = document.getElementById('newpass').value;
        $.ajax({
              url: "?r=users/save-pass",
              type: "POST",
              data: ({ 
                cbid: cbid,
                password: password,
                _csrf : '<?=Yii::$app->request->getCsrfToken()?>' 
              }),
              success: function(data) {
                  document.getElementById('userpass').innerHTML = 'Пароль янгиланди!';
              }
          });

    }
    function EightParol()
    {
        var userspassword = document.getElementById('newpass');
        var btn = document.getElementById('btn');
        if (userspassword.value.length>7) {
            btn.removeAttribute("disabled");
            // btn.style.background = 'green';
        }
        else{
            btn.setAttribute("disabled",true);
            // btn.style.background = 'lightgray';

        }
    }
</script>