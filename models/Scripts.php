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
 * @property string $name
 * @property string $data
  */
class Scripts extends \yii\db\ActiveRecord
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
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'   => 'ID',
            'lft'  => 'Left',
            'rgt'  => 'Right',
            'lvl'  => 'Level',
            'name' => 'Name',
            'data' => 'Data',
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

        if ($this->insert()) {
            return true;
        }
        return false;
    }

	/**
    * Удалить скрипт и все его дочерние элементы по id
    *
    * @var int $scriptId
    * @return boolean
    */
    public function delScript($scriptId = null)
    {
        $this->del($scriptId);
    }

    public function delLinks($scriptId = null)
    {
        $childs = $this->getBranch($scriptId);

        foreach ($childs as $child) {

            $links = self::find()->andWhere(['link' => $child->id])->all();

            foreach ($links as $link) {
                $this->del($link->id);
            }
        }
    }

    protected function del($scriptId = null)
    {
        if ($scriptId !== null) {

            $script = self::getScriptById($scriptId);

            self::deleteAll([
                'and',
                ['>=', 'lft', $script->lft],
                ['<=', 'rgt', $script->rgt],
            ]);
            self::updateAllCounters(
                ['rgt' => -($this->getAbs($script))],
                ['>', 'rgt', $script->rgt]
            );
            self::updateAllCounters(
                ['lft' =>  -($this->getAbs($script))],
                ['>', 'lft', $script->rgt]
            );
            return true;
        }
        return false;
    }

    /**
     * Возвращает количество дочерних элементов
     *
     * @var object $script
     * @return boolean / int
     */
    public function getAbs($script = null)
    {
        if ($script !== null && is_object($script)) {
            return $script->rgt - $script->lft + 1;
        }
        return false;
    }

    /**
     * Search script by id.
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
     * Search script by id.
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
     * Search script by id.
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

    /**
     * Возвращает родительский элемент
     */
    public function getParent($current = 0)
    {
        //$current = self::find()->where(['id' => $current]);
        $current = self::find()->where(['id' => 1])->one();

        return self::find()
            ->where([
                'and',
                ['<', 'lft', $current->lft],
                ['>', 'rgt', $current->rgt],
            ])
            ->one();
    }
}
