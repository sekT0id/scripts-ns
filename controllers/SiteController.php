<?php

namespace app\controllers;

use Yii;

use app\extended\controllers\BaseController;

use app\extended\models\Form;
use app\extended\models\Script;

class SiteController extends BaseController
{
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        // Представление данных таблицы со скриптами
        // в виде json, для bootstrap tree view
        $jsonTreeView = Script::getJsonTreeView();

        return $this->render('index', [
            'jsonTreeView' => $jsonTreeView,
        ]);
    }
}
