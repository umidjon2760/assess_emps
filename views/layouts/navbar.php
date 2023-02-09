<?php

use yii\helpers\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use app\models\AdminNotes;
?>
<?php
    NavBar::begin([
        'options' => [
            'class' => 'main-header navbar navbar-expand navbar-green navbar-dark',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => [
                            '<li class="nav-item">
                                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                            </li>',
                            
        ],
    ]);

    echo $this->render('navbar_right', ['assetDir' => $assetDir]);

    NavBar::end();
?>