<?php

namespace app\controllers;

use Yii;

use app\models\Form;
use app\models\Sessions;

class SessionController extends BaseController
{
    public function actionSave()
    {
        $model = new Form;
        $model->load(Yii::$app->request->post());

        $session = Sessions::getById($model->id);

        if ($session) {
            $session->comment = $model->comment;
            $session->save();
        }
        return $this->goHome();
    }
}
