<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Users;
use app\modules\baholash\models\AccessMatrix;
use app\modules\baholash\models\Zagr;
use hail812\adminlte\widgets\Menu;

// $name = Users::getShortName(Yii::$app->user->identity->ID);
// $lavozim = Users::getDoljName(Yii::$app->user->identity->ID);
if (isset(Yii::$app->user->ID)) {
    $name = Users::getShortName(Yii::$app->user->ID);
    $lavozim = Users::getDoljName(Yii::$app->user->ID);
}
else{
    return Yii::$app->response->redirect(Url::to(['site/login']));
}
Yii::$app->assetManager->forceCopy = true;
// var_dump($assetDir);
?>
<aside class="main-sidebar sidebar-dark-success sidebar-red elevation-4" style="background: #1E325E;">
    <!-- Brand Logo -->
    <a href="<?=\yii\helpers\Url::home()?>" class="brand-link">
        <img src="<?=$assetDir?>/img/AdminLTELogo.png" alt="Universal HR" class="brand-image">
        <span class="brand-text font-weight-light">Universal HR</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img style="border-radius: 8px;" src="<?=Users::getRasm(Yii::$app->user->ID)?>" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?=$name?></a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">

            <?php
            if(!Yii::$app->user->isGuest)
            echo Menu::widget([
                'options'=>['class'=>'nav nav-pills nav-sidebar nav-child-indent flex-column','data-widget'=>'treeview','role'=>'menu'],

                'items' => [
                    
                    ['label' => 'Фойдаланувчилар', 'url' => ['/users/index'], 'icon' => 'fas fa-user-lock','visible'=>!Yii::$app->user->isGuest&&AccessMatrix::getAccess('admin',Yii::$app->user->ID)],

                    ['label' => 'Фойдаланувчилар', 'url' => ['/users/my-index'], 'icon' => 'fas fa-user-lock','visible'=>!Yii::$app->user->isGuest&&AccessMatrix::getAccess('co_user',Yii::$app->user->ID)],

                    ['label' => 'Бахолаш', 'url' => [Zagr::getUrl()], 'icon' => 'chart-line',],

                    ['label' => 'Слайдлар', 'url' => ['/site/slides-view'], 'icon' => 'file-powerpoint','visible'=>(!Yii::$app->user->isGuest&&AccessMatrix::getAccess('admin',Yii::$app->user->ID))||(!Yii::$app->user->isGuest&&AccessMatrix::getAccess('baho_admin',Yii::$app->user->ID))],

                    ['label' => 'Менинг сахифам', 'url' => ['/users/view','id'=>Yii::$app->user->ID], 'icon' => 'user-circle',],
                    
                    ['label' => 'Тизимдан чиқиш','url' => ['/site/logout'], 'data-method' => 'post', 'icon'=>'fas fa-sign-out-alt','visible' => !Yii::$app->user->isGuest],
                ],
            ]);

            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>