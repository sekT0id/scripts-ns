<?php

namespace app\extended\models;

use Yii;
use yii\helpers\Url;
use yii\web\UploadedFile;

/**
 * This is the model class for table "script".
 *
 * @property integer $id
 * @property integer $path
 * @property string $name
 * @property string $text
 * @property integer $secure
 */
class Script extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'script';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['path', 'text'], 'string'],
            [['name'], 'string', 'max' => 150],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'path' => 'Path',
            'name' => 'Name',
            'text' => 'Text',
        ];
    }

    /**
     * Генерирует дерево скриптов
     * return array
     */
    public static function getArrayTreeView()
    {
        // Временное хранилище для дерева
        $tree = [];

        $scripts = self::find()
            ->orderBy([
                'path' => SORT_ASC,
                'id' => SORT_ASC,
            ])
            ->all();

        foreach ($scripts as $script) {

            // Формируем добавляемый элемент
            $pushed = [
                'text' => $script->name,
                'id' => $script->id,
                'href' => Url::toRoute(['/script/view', 'script' => $script->id]),
                'tags' => [
                    '<a href="'.Url::toRoute(['/script/edit', 'script' => $script->id]).'"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>',
                ],
            ];

            if ($script->path == '') {
                // Заполняем верхний уровень дерева
                // Элементы с пустым путем
                $tree[$script->id] = $pushed;
            } else {
                // Заполняем дочерние элементы дерева
                $path = explode('.', $script->path);
                $treeLink = &$tree;

                // Идем по "пути" скрипта
                // Для дочерних элементов добавляем 'nodes'
                foreach ($path as $key) {
                    if ($key != '') {
                        $treeLink = &$treeLink[$key];
                        $treeLink = &$treeLink['nodes'];
                    }
                }

                if (is_array($treeLink)) {
                    // Если текущий элемент является массивом
                    // Значит здесь уже есть дочерние элементы
                    // Добавляем к ним ещё один.
                    array_push($treeLink, $pushed);
                } else {
                    // Иначе создаем новый.
                    $treeLink[$script->id] = $pushed;
                }
                unset($treeLink);
            }
        }
        return array_values($tree);
    }

    /**
     * Возвращает дерево в виде Json
     * return Json
     */
    public static function getJsonTreeView()
    {
        return json_encode(self::getArrayTreeView());
    }
}
