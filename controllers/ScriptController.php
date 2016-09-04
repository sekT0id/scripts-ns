<?php

namespace app\controllers;

use Yii;

use app\models\Form;
use app\models\Scripts;

class ScriptController extends BaseController
{
    /**
     * Create new script action.
     *
     * @return string
     */
    public function actionNew()
    {
        $model = new Form;
        $scripts = Scripts::find()->all();

        return $this->render('edit', [
            'model' => $model,
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
        $script = $this->getScriptById($script);

        $scriptRecent = Scripts::find()
//            ->andWhere(['path' => $searchedPath])
            ->orderBY([
                //'path' => SORT_ASC,
            ])
            ->all();

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
        $scripts = Scripts::find()->all();

        return $this->render('edit', [
            'model' => $model,
            'script' => $this->getScriptById($script),
        ]);
    }

    /**
     * Delete script action
     */
    public function actionDelete()
    {
        $model = new Form();
        $model->load(Yii::$app->request->post());

        $script = $this->getScriptById($model->id);

        if ($script->path) {
            $searchedPath = $script->path.'.';
        }

        $searchedPath = $searchedPath.$script->id;

        $script->delete();
        Scripts::deleteAll(['like', 'path', $searchedPath.'%', false]);

        return $this->goHome();
    }

    /**
    * Save script action - готов
    */
    public function actionSave()
    {
        $model = new Form();
        $model->load(Yii::$app->request->post());

        $script = new Scripts();

        $script->name   = $model->name;
        $script->data   = $model->text;

        // Если передан id скрипта,
        // значит находимся в режиме редактирования
        if ($model->id) {
            $script->id = $model->id;
            $script->isNewRecord = false;
            $script->save();
        // Иначе режим добавления
        } else {
            $script->add();
        }

        return $this->goHome();
        exit;
    }


    /**
     * Search script by id.
     *
     * @return string
     */
    protected function getScriptById($id = null)
    {
        if ($id !== null) {
            if ($script = Scripts::find()->andWhere(['id' => $id])->one()) {
                return $script;
            }
            return false;
        }
        return false;
    }
}
