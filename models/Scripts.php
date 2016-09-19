<?php

namespace app\models;

use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "script".
 *
 * @property integer $id
 * @property integer $lft
 * @property integer $rgt
 * @property integer $lvl
 * @property integer $link
 * @property string $name
 * @property string $data
  */
class Scripts extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'scripts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'data'], 'string'],
            [['name'], 'string', 'max' => 150],
            [['userId'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'    => 'ID',
            'lft'   => 'Left',
            'rgt'   => 'Right',
            'lvl'   => 'Level',
            'link'  => 'Link',
            'name'  => 'Name',
            'data'  => 'Data',
        ];
    }

    /**
     * Создает корень дерева скриптов
     */
    public function createRoot()
    {
        $script = new Scripts;

        $script->lft = 0;
        $script->rgt = 1;
        $script->lvl = 0;
        $script->name = '';
        $script->data = '';

        $script->save();
    }

    /**
     * Возвращает корневой элемент
     *
     * @return object
     */
    public function getRoot()
    {
        return self::find()->where(['lft' => 0])->one();
    }

	/**
    * Добавляет дочерний элемент по id родителя
    *
    * @var int $parentId
    * @return boolean
    */
    public function add($parentId = null)
    {
        // Запускаем транзакцию, так как будем выполнять
        // достаточно объемные работы
        $transaction = Yii::$app->db->beginTransaction();
        try {

            // Проверяем существование корня
            // если нет, то создаем
            if (!$this->getRoot()) {
                $this->createRoot();
            }

            // Если не указан родительский скрипт
            // то добавляем новый элемент от корня
            if($parentId != null){
                //Начитываем параметры родительского элемента
                $parentAttributes = self::find()
                    ->where(['id' => $parentId])
                    ->one();
            } else {
                $parentAttributes = $this->getRoot();
            }

            //выделяем место в дереве, для добавления нового элемента
            self::updateAllCounters(
                ['rgt' => 2],
                ['>=', 'rgt', $parentAttributes->rgt]
            );
            self::updateAllCounters(
                ['lft' => 2],
                ['>=', 'lft', $parentAttributes->rgt]
            );

            //добавляем новый элемент
            $this->lft = $parentAttributes->rgt;
            $this->rgt = $parentAttributes->rgt+1;
            $this->lvl = $parentAttributes->lvl+1;

            $this->insert();

            $transaction->commit();

        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
        return true;
    }

	/**
    * Обновляет скрипт по id
    * Также обновляет все созданные на него ссылки
    *
    * @var int $scriptId
    * @return boolean
    */
    public function upd()
    {
        // Запускаем транзакцию, так как будем выполнять
        // достаточно объемные работы
        $transaction = Yii::$app->db->beginTransaction();
        try {

            $this->save();
            $this->updLinks();

            $transaction->commit();

        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
        return true;
    }

	/**
    * Обновляет все ссылки на текущий скрипт
    */
    protected function updLinks()
    {
        self::updateAll(['name' => $this->name], ['link' => $this->id]);
    }

	/**
    * Удалить скрипт и все его дочерние элементы по id
    * Также удаляет все созданные на эти элементы ссылки
    *
    * @var int $scriptId
    * @return boolean
    */
    public function del($scriptId = null)
    {
        // Запускаем транзакцию, так как будем выполнять
        // достаточно объемные работы
        $transaction = Yii::$app->db->beginTransaction();
        try {

            $this->delLinks($scriptId);
            $this->delScript($scriptId);

            $transaction->commit();

        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
        return true;
    }

	/**
    * Удаляет все ссылки созданные на скрипт
    * и его дочерние элементы.
    *
    * Предназначена для функции del
    *
    * @var int $scriptId
    * @return boolean
    */
    protected function delLinks($scriptId = null)
    {
        if ($scriptId !==null) {
            $childs = $this->getBranch($scriptId);

            foreach ($childs as $child) {

                $links = self::find()->andWhere(['link' => $child->id])->all();

                foreach ($links as $link) {
                    $this->delScript($link->id);
                }
            return true;
            }
        }
        return false;
    }

    /**
     * Удаляет скрипт по Id и осуществляет
     * смещение дерева.
     *
     * Предназначена для функции delScript
     *
     * @var int $scriptId
     * @return boolean
     */
    protected function delScript($scriptId = null)
    {
        if ($scriptId !== null) {

            $script = self::getScriptById($scriptId);

            self::deleteAll([
                'and',
                ['>=', 'lft', $script->lft],
                ['<=', 'rgt', $script->rgt],
            ]);
            self::updateAllCounters(
                ['rgt' => -($this->getElementsOffset($script))],
                ['>', 'rgt', $script->rgt]
            );
            self::updateAllCounters(
                ['lft' =>  -($this->getElementsOffset($script))],
                ['>', 'lft', $script->rgt]
            );
            return true;
        }
        return false;
    }

    /**
     * Вычисляет смещение для манипуляций с деревом
     *
     * @var object $script
     * @return boolean / int
     */
    public function getElementsOffset($script = null)
    {
        if ($script !== null && is_object($script)) {
            return $script->rgt - $script->lft + 1;
        }
        return false;
    }

    /**
     * Ищет скрипт по id.
     *
     * @var int $scriptId
     * @return boolean / object
     */
    public static function getScriptById($scriptId = null)
    {
        if ($scriptId !== null) {
            if ($script = self::find()->andWhere(['id' => $scriptId])->one()) {
                return $script;
            }
            return false;
        }
        return false;
    }

    /**
     * Ищет дочерние элементы скрипта.
     *
     * @var int / object $script
     * @return boolean / object
     */
    public static function getScriptChildren($script = null)
    {
        if ($script !== null) {
            if (is_int($script)) {
                $script = self::getScriptById($script);
            }

            if (is_object($script)) {

                return self::find()
                    ->andWhere(['>', 'lft', $script->lft])
                    ->andWhere(['<', 'rgt', $script->rgt])
                    ->andWhere(['lvl' => $script->lvl + 1])
                    ->orderBY([
                        'lft' => SORT_ASC,
                    ])
                    ->all();
            }
            return false;
        }
        return false;
    }

    /**
     * Ищет ветку дерева
     * (текущий скрипт и все его дочерние элементы)
     * по родительскому скрипту.
     *
     * @var int / object $script
     * @return boolean / object
     */
    public static function getBranch($script = null)
    {
        if ($script !== null) {
            if (is_int($script) || is_string($script)) {
                $script = self::getScriptById($script);
            }

            if (is_object($script)) {

                return self::find()
                    ->andWhere(['>=', 'lft', $script->lft])
                    ->andWhere(['<=', 'rgt', $script->rgt])
                    ->orderBY([
                        'lft' => SORT_ASC,
                    ])
                    ->all();
            }
            return false;
        }
        return false;
    }
}
