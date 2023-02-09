<?php

use yii\helpers\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use app\modules\baholash\models\AccessMatrix;
use app\modules\baholash\models\Fact;

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
                            [
                                'label' => 'Маълумотлар', 
                                'items' => [
                                    ['label' => 'Филиал сессиялари (360)', 'url' => ['/baholash/session/fil-all-session'], 'iconStyle' => 'far',],  
                                    ['label' => 'Филиал сессиялари (KPI)', 'url' => ['/baholash/session/fil-kpi-session'], 'iconStyle' => 'far',],  
                                    ['label' => 'Факт', 'url' => ['/baholash/fact/index'], 'iconStyle' => 'far',],  
                                    ['label' => 'Филиаллар', 'url' => ['/baholash/filials/index'], 'iconStyle' => 'far',],  
                                    ['label' => 'Период', 'url' => ['/baholash/period/index'], 'iconStyle' => 'far'],
                                    ['label' => 'Показатель', 'url' => ['/baholash/pokaz/index'], 'iconStyle' => 'far'],
                                    ['label' => 'Богланишлар', 'url' => ['/baholash/relation/index'], 'iconStyle' => 'far'],
                                    ['label' => 'Богланишлар(гурух)', 'url' => ['/baholash/relation-group/index'], 'iconStyle' => 'far'],
                                    ['label' => 'Богланиш-показ', 'url' => ['/baholash/rel-pokaz/index'], 'iconStyle' => 'far'],
                                    ['label' => 'Сессиялар', 'url' => ['/baholash/session/index'], 'iconStyle' => 'far'],
                                    ['label' => 'Загруженность', 'url' => ['/baholash/zagr/index'], 'iconStyle' => 'far'],
                                    ['label' => 'Загруженность(архив)', 'url' => ['/baholash/zagr-arch/index'], 'iconStyle' => 'far'],
                                    ['label' => 'Рухсатлар матрицаси', 'url' => ['/baholash/access-matrix/index'], 'iconStyle' => 'far'],
                                    ['label' => 'KPI карталар', 'url' => ['/baholash/kpi-card/all'], 'iconStyle' => 'far'],
                                    ['label' => 'Почта (тест)', 'url' => ['/baholash/zagr/pochta'], 'iconStyle' => 'far'],
                                    ['label' => 'Query', 'url' => ['/baholash/zagr/query-to-real'], 'iconStyle' => 'far','visible' => (!Yii::$app->user->isGuest&&AccessMatrix::getAccess('admin',Yii::$app->user->ID))||(!Yii::$app->user->isGuest&&AccessMatrix::getAccess('baho_admin',Yii::$app->user->ID))],
                                ],
                                'visible' => (!Yii::$app->user->isGuest&&AccessMatrix::getAccess('admin',Yii::$app->user->ID))||(!Yii::$app->user->isGuest&&AccessMatrix::getAccess('baho_admin',Yii::$app->user->ID)), 
                            ],
                            ['label' => 'Юклаш', 'url' => ['/baholash/zagr/upload'], 'iconStyle' => 'far','visible' => (!Yii::$app->user->isGuest&&AccessMatrix::getAccess('admin',Yii::$app->user->ID))||(!Yii::$app->user->isGuest&&AccessMatrix::getAccess('baho_admin',Yii::$app->user->ID)),],
                            ['label' => 'Хисоботлар', 'url' => ['/baholash/zagr/otchet'], 'iconStyle' => 'far','visible' => (!Yii::$app->user->isGuest&&AccessMatrix::getAccess('admin',Yii::$app->user->ID))||(!Yii::$app->user->isGuest&&AccessMatrix::getAccess('baho_admin',Yii::$app->user->ID))], 
                            // ['label' => 'Бахолаш', 'url' => ['/baholash/zagr/baho-emps'], 'iconStyle' => 'far','visible'=>!Yii::$app->user->isGuest&&Fact::isLov(Yii::$app->user->ID,'now')],
                            ['label' => 'Бахолаш (360)', 'url' => ['/baholash/zagr/baho-all'], 'iconStyle' => 'far','visible'=>!Yii::$app->user->isGuest&&Fact::isLovAll(Yii::$app->user->ID)],
                            ['label' => 'Бахолаш (KPI)', 'url' => ['/baholash/zagr/baho-kpi'], 'iconStyle' => 'far','visible'=>!Yii::$app->user->isGuest&&Fact::isLovKPi(Yii::$app->user->ID)],
                            ['label' => 'Ходимлар бахолари', 'url' => ['/baholash/zagr/enter-baho-old'], 'iconStyle' => 'far','visible'=>!Yii::$app->user->isGuest&&Fact::isLov(Yii::$app->user->ID,'all')],
                            ['label' => 'Менинг бахоларим', 'url' => ['/baholash/zagr/baho-emps-old'], 'iconStyle' => 'far','visible'=>!Yii::$app->user->isGuest&&Fact::isNuv(Yii::$app->user->ID)],
                            ['label' => 'Филиал бахолаш (360)', 'url' => ['/baholash/session/filial-baho-all'], 'iconStyle' => 'far','visible'=>!Yii::$app->user->isGuest&&AccessMatrix::getAccess('co_user',Yii::$app->user->ID)],
                            ['label' => 'Филиал бахолаш (KPI)', 'url' => ['/baholash/session/filial-baho-kpi'], 'iconStyle' => 'far','visible'=>!Yii::$app->user->isGuest&&AccessMatrix::getAccess('co_user',Yii::$app->user->ID)],
                            ['label' => 'Ходимлар KPI', 'url' => ['/baholash/zagr/emp-kpi'], 'iconStyle' => 'far','visible'=>(!Yii::$app->user->isGuest&&AccessMatrix::getAccess('co_user',Yii::$app->user->ID))||(!Yii::$app->user->isGuest&&AccessMatrix::getAccess('admin',Yii::$app->user->ID))],
                            ['label' => 'Менинг KPI', 'url' => ['/baholash/kpi-card/my-kpi'], 'iconStyle' => 'far','visible'=>!Yii::$app->user->isGuest],
                            // ['label' => 'Ходимлар бахолари', 'url' => ['/baholash/zagr/enter-baho-old'], 'iconStyle' => 'far','visible'=>!Yii::$app->user->isGuest&&Fact::isNuv(Yii::$app->user->ID,'not_now')],
                           

        ],
    ]);

    echo $this->render('navbar_right', ['assetDir' => $assetDir]);

    NavBar::end();
?>