<?php

namespace app\controllers;

use Yii;

use app\models\Form;
use app\models\Scripts;

class ScriptController extends BaseController
{

    public function goHome()
    {
        return $this->redirect(['/site/view', 'alias' => 'scripts']);
    }

    /**
     * Create new script action.
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
     * Displays script by id.
     *
     * @return string
     */
    public function actionView($script)
    {
        $script = Scripts::getScriptById($script);
        $scriptRecent = Scripts::getScriptChildren($script);

        return $this->render('view', [
            'script'       => $script,
            'scriptRecent' => $scriptRecent,
        ]);
    }

    /**
     * Edit existed script. - готов
     *
     * @return string
     */
    public function actionEdit($script)
    {
        $model = new Form;

        return $this->render('edit', [
            'model' => $model,
            'parentId' => false,
            'script' => Scripts::getScriptById($script),
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

        $script->delLinks($scriptId);
        $script->delScript($scriptId);

        return $this->goHome();
        exit;
    }

    /**
    * Save script action - готов
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

        $script->name   = $model->name;
        $script->data   = $model->text;

        // Если передан id скрипта,
        // значит находимся в режиме редактирования
        if ($model->id) {
            $script->save();
        // Иначе режим добавления
        } else {
            $script->add($model->parentId);
        }

        return $this->goHome();
        exit;
    }

    public function actionAddlink()
    {
        $model = new Form();
        $script = new Scripts();

        $model->load(Yii::$app->request->post());
        $targetAttributes = Scripts::getScriptById($model->id);

        $script->name = $targetAttributes->name;
        $script->link = $model->id;
        $script->add($model->parentId);

        return $this->goHome();
        exit;
    }
}
