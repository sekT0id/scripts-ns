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
     */
    public function checkRoot()
    {
        return self::find()->where(['lft' => 0])->one();
    }

	/**
    * Добавляет дочерний элемент по id родителя
    */
    public function add($parentScript = null)
    {
        // Проверяем существование корня
        // если нет, то создаем
        if (!$this->checkRoot()) {
            $this->createRoot();
        }

		// Если не указан родительский скрипт
        // то добавляем новый элемент от корня
    	if(!$parentScript === null){
            //Начитываем параметры родительского элемента
            $parentAttributes = self::find()
                ->where(['id' => $parentScript])
                ->one();
    	} else {
            $parentAttributes = $this->checkRoot();
        }

        //выделяем место в дереве, для добавления нового элемента
        self::updateAllCounters(['rgt' => 2], ['>=', 'rgt', $parentAttributes->rgt]);
        self::updateAllCounters(['lft' => 2], ['>=', 'lft', $parentAttributes->rgt]);

        //добавляем новый элемент
        $this->lft = $parentAttributes->rgt;
        $this->rgt = $parentAttributes->rgt+1;
        $this->lvl = $parentAttributes->lvl+1;
        $this->insert();
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
