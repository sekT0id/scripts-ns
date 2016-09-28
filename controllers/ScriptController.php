<?php

namespace app\controllers;

use Yii;

use app\models\Form;
use app\models\Scripts;
use app\models\Clients;
use app\models\Sessions;
use app\models\SessionsDetails;

class ScriptController extends BaseController
{

//    public function beforeAction($action)
//    {
//        // Неавторизованный пользователь перенаправляется
//        // на страницу авторизации
//        if (parent::beforeAction($action)) {
//            Yii::$app->db->beginTransaction();
//            return true;
//        }
//    }
//
//    public function afterAction($action, $result)
//    {
//        $result = parent::afterAction($action, $result);
//
//            Yii::$app->db->transaction->commit();
//
//            $exception = \Yii::$app->errorHandler->exception;
//
//            if ($exception !== null) {
//                $transaction->rollBack();
//            }
//
//        return $result;
//    }

    public function goHome()
    {
        return $this->redirect(['/site/view', 'alias' => 'scripts']);
    }

    /**
     * Display script editor for new script
     *
     * @return string
     */
    public function actionNew($script = null)
    {
        $model = new Form;
        $scripts = Scripts::find()->all();

        return $this->render('edit', [
            'model' => $model,
            'parentId' => $script,
            'script' => false,
            'scripts' => $scripts,
        ]);
    }

    /**
     * Display script by id.
     *
     * @return string
     */
    public function actionView($script = null)
    {
        // php сессия живет только в рамках сессии звонка.
        // При выходе из сесии звонка, php сессия разрушается.
        $session = Yii::$app->session;
        $session->open();

        // Если не получили id скрипта из $_GET
        if ($script === null) {

            // То пробуем смотреть его в $_POST
            $model = new Form;
            $model->load(Yii::$app->request->post());

            // Если id скрипта передано из формы,
            // значит стартуем новую сессию звонка
            if (isset($model->clientId)) {

                $client = Clients::getById($model->clientId);

                $modelSession = new Sessions;
                $modelSession->clientId  = $model->clientId;

                // Записываем в php сессию идентификатор
                // текущего клиента.
                $session['clientId']  = $model->clientId;

                // Записываем в php сессию идентификатор
                // текущей сессии звонка.
                // $modelSession->start() создает новую запись
                // и возвращает её идентификатор в случае успеха.
                $session['sessionId'] = $modelSession->start();

                $client->hasSession = 1;
                $client->update();
            }
            $script = $model->id;
        }

        // Если php сессия существует,
        // значит находимся в рамках сесси звонка
        // и значит записываем детали переходов
        if (isset($session['sessionId'])) {
            $modelSessionDetails = new SessionsDetails;
            $modelSessionDetails->sessionId = $session['sessionId'];
            $modelSessionDetails->scriptId = $script;
            $modelSessionDetails->insert();
        }

        $script = Scripts::getById($script);
        $scriptRecent = Scripts::getScriptChildren($script);

        return $this->render('view', [
            'script'       => $script,
            'scriptRecent' => $scriptRecent,
        ]);
    }

    /**
     * Display script editor
     *
     * @return string
     */
    public function actionEdit($script)
    {
        $model = new Form;

        return $this->render('edit', [
            'model' => $model,
            'parentId' => false,
            'script' => Scripts::getById($script),
        ]);
    }

    /**
     * Delete script action
     */
    public function actionDelete($script = null)
    {
        $scriptId = null;

        if ($script === null) {
            $model = new Form();
            $model->load(Yii::$app->request->post());
            $scriptId = $model->id;
        }

        if ($script !== null) {
            $scriptId = $script;
        }

        $script = new Scripts;
        $script->del($scriptId);

        return $this->goHome();
        exit;
    }

    /**
    * Save script action
    */
    public function actionSave()
    {
        $model = new Form();
        $script = new Scripts();

        $model->load(Yii::$app->request->post());

        if ($model->id) {
            $script->id = $model->id;
            $script->isNewRecord = false;
        }

        $script->userId = Yii::$app->user->id;
        $script->name   = $model->name;
        $script->data   = $model->text;

        // Если передан id скрипта,
        // значит находимся в режиме редактирования
        if ($model->id) {
            // Обновляем данные скрипта
            // Также обновляем все ссылки на этот скрипт
            $script->upd();
        // Иначе режим добавления
        } else {
            $script->add($model->parentId);
        }

        return $this->goHome();
        exit;
    }

    /**
     * Добавляем ссылку на скрипт
     */
    public function actionAddlink()
    {
        $model = new Form();
        $script = new Scripts();

        $model->load(Yii::$app->request->post());
        $targetAttributes = Scripts::getById($model->id);

        $script->userId = Yii::$app->user->id;
        $script->name = $targetAttributes->name;
        $script->link = $model->id;
        $script->add($model->parentId);

        return $this->goHome();
        exit;
    }
}
