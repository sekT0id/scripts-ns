<?php

namespace app\controllers;

use Yii;

use app\models\Form;
use app\models\Clients;

class ClientController extends BaseController
{
    public function goHome()
    {
        return $this->redirect(['/site/view', 'alias' => 'clients']);
    }

    public function actionEdit($clientId = null)
    {
        $model = new Form;

        return $this->render('edit', [
            'model' => $model,
            'data' => Clients::getById($clientId),
        ]);
    }

   /**
    * Save client action
    */
    public function actionSave()
    {
        $model  = new Form();
        $client = new Clients();

        $model->load(Yii::$app->request->post());

        // Если передан id клиента,
        // значит находимся в режиме редактирования
        if ($model->id) {
            $client->id = $model->id;
            $client->isNewRecord = false;
        }

        $client->name   = $model->name;
        $client->phone  = $model->phone;
        $client->data   = $model->data;

        $client->save();

        return $this->goHome();
        exit;
    }

    /**
     * Delete client action
     */
    public function actionDelete()
    {
        $model = new Form();
        $model->load(Yii::$app->request->post());

        $client = Clients::getById($model->id);
        $client->delete();

        return $this->goHome();
        exit;
    }
}
