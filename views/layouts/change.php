<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;

\hail812\adminlte3\assets\FontAwesomeAsset::register($this);
\hail812\adminlte3\assets\AdminLteAsset::register($this);


$assetDir = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
$this->registerCssFile($assetDir.'/css/fontawesome.css');

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php 
        $this->head(); 
        $this->registerCssFile('./css/site.css');
        // $this->registerCssFile('./css/bootstrap.css');
        // $this->registerCssFile('./css/bootstrap-theme.css');
        // $this->registerJsFile('./js/jquery.min.js', $options = [], $key = null );//регестрирует ссылку на js файл
    ?>
    
</head>
<body class="hold-transition sidebar-mini sidebar-collapse layout-navbar-fixed">
<?php $this->beginBody() ?>

<div class="wrapper">
    <!-- Navbar -->
    
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
     <?= $this->render('navbar_change', ['assetDir' => $assetDir]) ?>

    <!-- Content Wrapper. Contains page content -->
    <?= $this->render('content', ['content' => $content, 'assetDir' => $assetDir]) ?>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
