<?php

namespace app\widgets;

use yii\helpers\Html;
use app\models\Scripts;
use yii\base\InvalidConfigException;

class TreeView extends BaseWidget
{
    // Модель данных
    public $model = null;

    // Тип отрисовки дерева
    public $treeType = 'simpleTree';
    public $treeOptions = [
        'id' => 'tree',
    ];

    // Параметры тега обертки
    public $nodeTag = 'ul';
    public $nodeOptions = [];

    // Параметры тега элемента
    public $itemTag = 'li';
    public $itemOptions = [];

    // Тэг отступа для simpleList
    public $indentTag = 'span';
    public $indentContent = '';
    public $indentOptions = ['class' => 'indent'];

    private $level = 0;

    public function getTreeOptions()
    {
        $options = '';
        if (is_array($this->treeOptions)) {
            if ($this->treeOptions != []) {
                foreach ($this->treeOptions as $key => $value) {
                    $options .= ' '.$key.'="'.$value.'"';
                }
            }
            return trim($options);
        }
        throw new InvalidConfigException('Не верно задан массив параметров дерева');
    }

    /**
     * Возвращает открывающий тег для ноды
     */
    public function nodeOpenTag()
    {
        return Html::beginTag($this->nodeTag, $this->nodeOptions);
    }

    /**
     * Возвращает закрывающий тег для ноды
     */
    public function nodeCloseTag()
    {
        return Html::endTag($this->nodeTag);
    }

    public function itemOpenTag()
    {
        return Html::beginTag($this->itemTag, $this->itemOptions);
    }

    public function itemCloseTag()
    {
        return Html::endTag($this->itemTag);
    }

//    public function renderItem($viewName = null, $options = null) {
//        return $this->render('treeview/_item', ['item' => $item])
//    }

    /**
     * Формируем дерево
     */
    public function getSimpleTree()
    {
        $list = '';

        foreach ($this->model as $item) {

            // Исключаем из вывода корень дерева
            if ($item->lft != 0) {

                // Открываем тэг элемента
                $list .= $this->itemOpenTag();

                // Добавляем отступы
                for ($i = 1; $i < $item->lvl; $i++) {
                    $list .= Html::tag($this->indentTag, $this->indentContent, $this->indentOptions);
                }

                // Рендерим контент элемента из вьюшки
                $list .= $this->render('treeview/_simpleItem', ['item' => $item]);

                // закрываем тег элемента
                $list .= $this->itemCloseTag();
            }
        }
        return $this->nodeOpenTag() . $list . $this->nodeCloseTag();
    }

    public function getNestedTree()
    {
        //$list = $this->nodeOpenTag();

        foreach ($this->model as $item) {
if ($item->lft != 0) {
            if ($this->level > $item->lvl) {
                $list .= $this->nodeCloseTag();
                $list .= $this->itemCloseTag();
            }

            if ($this->level < $item->lvl) {
                $list .= $this->nodeOpenTag();
            }

            $list .= $this->itemOpenTag();
            $list .= $this->render('treeview/_nestedItem', ['item' => $item]);
}
            $this->level = $item->lvl;
        }

        for ($i = 1; $i < $this->level; $i++) {
            $list .= $this->nodeCloseTag();
            $list .= $this->itemCloseTag();
        }

        //$list .= $this->nodeCloseTag();

        return $list;
    }

    public function init()
    {
        parent::init();

        if ($this->model == null) {
            $this->model = Scripts::find()
                ->orderBy('lft')
                ->all();
        }

        $this->data['treeOptions'] = $this->getTreeOptions();

        if ($this->treeType == 'simpleTree') {
            $this->data['treeView'] = $this->getSimpleTree();
        }
        if ($this->treeType == 'nestedTree') {
            $this->data['treeView'] = $this->getNestedTree();
        }
    }
}
