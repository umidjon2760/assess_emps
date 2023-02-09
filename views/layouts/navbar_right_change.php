<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\AdminNotes;
use app\models\Users;
// $name = Users::getShortName(Yii::$app->user->ID);
// $lavozim = Users::getDoljName(Yii::$app->user->ID);
if (isset(Yii::$app->user->ID)) {
    
    
        $name = Users::getShortName(Yii::$app->user->ID);
        $lavozim = Users::getDoljName(Yii::$app->user->ID);
    
}
else{
    return Yii::$app->response->redirect(Url::to(['site/login']));
}
?>
 <!-- Right navbar links -->
    

<style type="text/css">
    .navbar-nav>.user-menu>.dropdown-menu>li.user-header>p {
        margin-top: 0;
    }
</style>