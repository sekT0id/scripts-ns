<?php

namespace app\controllers;

use Yii;

use app\models\Form;
use app\models\Scripts;

class SiteController extends BaseController
{
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index', [
            'tree' => Scripts::find()->all(),
        ]);
    }
}
