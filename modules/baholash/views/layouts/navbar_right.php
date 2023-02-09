<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Users;
if (isset(Yii::$app->user->ID)) {
    if (md5(Yii::$app->user->ID)==Users::getPassword(Yii::$app->user->ID)) {
        return Yii::$app->response->redirect(Url::to(['change/changeparol']));
    }
    else{
        $name = Users::getShortName(Yii::$app->user->ID);
        $lavozim = Users::getDoljName(Yii::$app->user->ID);
    }
}
else{
    return Yii::$app->response->redirect(Url::to(['site/login']));
}
// if (isset(Yii::$app->user->ID)) {
//     $name = Users::getShortName(Yii::$app->user->ID);
//     $lavozim = Users::getDoljName(Yii::$app->user->ID);
// }
// else{
//     return Yii::$app->response->redirect(Url::to(['site/login']));
// }
?>
 <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto top-right-menu">
         <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                <img src="<?=Users::getRasm(Yii::$app->user->ID)?>" class="user-image img-circle elevation-2" alt="User Image">
                <span class="d-none d-md-inline"><?=$name?></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <!-- User image -->
                <li class="user-header bg-danger">
                    <img src="<?=Users::getRasm(Yii::$app->user->ID)?>" style='border-radius: 40px;' class="elevation-2" alt="User Image">

                    <p>
                        <?=$name?>
                        <small><?=$lavozim?></small>
                    </p>
                </li>
                <!-- Menu Body -->
                
                <!-- Menu Footer-->
                <li class="user-footer">
                    <a  style="width: 100%;" href="?r=users/view&id=<?=Yii::$app->user->ID?>" class="btn btn-default btn-flat">Cахифам</a>
                </li>
                <li class="user-footer" >
                    <?= Html::a('Чиқиш', ['/site/logout'], ['data-method' => 'post', 'style'=>'width:100%;','class' => 'btn btn-default btn-flat']) ?>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button"><i
                    class="fas fa-th-large"></i></a>
        </li>
    </ul>

<style type="text/css">
    .navbar-nav>.user-menu>.dropdown-menu>li.user-header>p {
        margin-top: 0;
    }
</style>