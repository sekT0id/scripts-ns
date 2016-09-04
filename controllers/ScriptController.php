<?php

namespace app\controllers;

use Yii;

use app\extended\controllers\BaseController;

use app\extended\models\Form;
use app\extended\models\Script;

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
        $scripts = Script::find()->all();

        return $this->render('edit', [
            'model' => $model,
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
        $searchedPath = '';

        if ($script->path) {
            $searchedPath = $script->path.'.';
        }

        $searchedPath = $searchedPath.$script->id;
        $scriptRecent = Script::find()
            ->andWhere(['path' => $searchedPath])
            ->orderBY([
                'path' => SORT_ASC,
            ])
            ->all();

        return $this->render('view', [
            'script'       => $script,
            'scriptRecent' => $scriptRecent,
            'scriptParent' => substr($script->path, -1),
        ]);
    }

    /**
     * Edit existed script.
     *
     * @return string
     */
    public function actionEdit($script)
    {
        $model = new Form;
        $scripts = Script::find()->all();

        return $this->render('edit', [
            'model' => $model,
            'script' => $this->getScriptById($script),
            'scripts' => $scripts,
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
        Script::deleteAll(['like', 'path', $searchedPath.'%', false]);

        return $this->goHome();
    }

    /**
    * Save script action
    */
    public function actionSave()
    {
        $model = new Form();
        $model->load(Yii::$app->request->post());

        $script = new Script();

        if ($model->id) {
            $script->id = $model->id;
            $script->isNewRecord = false;
        }

        $script->name   = $model->name;
        $script->text   = $model->text;
        $script->path   = $model->path;

        $script->save();
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
            if ($script = Script::find()->andWhere(['id' => $id])->one()) {
                return $script;
            }
            return false;
        }
        return false;
    }
}
