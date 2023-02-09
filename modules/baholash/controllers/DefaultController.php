<?php

namespace app\modules\baholash\controllers;

use yii\web\Controller;

/**
 * Default controller for the `bb` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public $layout = 'baho'; 
    public function actionIndex()
    {
        return $this->render('index');
    }
}
