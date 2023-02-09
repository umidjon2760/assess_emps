<?php

use yii\helpers\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;


?>
<?php
    NavBar::begin([
        'options' => [
            'class' => 'main-header navbar navbar-expand navbar-red navbar-dark',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => [
                            '<li class="nav-item">
                                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                            </li>',
                            // ['label' => 'Филиаллар', 'url' => ['/filials/index'], 'iconStyle' => 'far',],
                            
                           

        ],
    ]);

    echo $this->render('navbar_right', ['assetDir' => $assetDir]);

    NavBar::end();
?>