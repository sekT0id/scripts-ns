<?php

namespace app\widgets;

use yii\helpers\Html;
use app\models\Scripts;

class TreeView extends BaseWidget
{
    // Тип генерации дерева
    // simpleList / nestedList
    public $treeType = 'simpleList';
    public $treeOptions = 'tree';

    // Модель данных
    public $model = null;

    // Параметры тега обертки
    public $nodeTag = 'ul';
    public $nodeOptions = [];

    // Параметры тега элемента
    public $itemTag = 'li';
    public $itemOptions = [];

    // Тэг отступа для simpleList
    // Используется в bootstrap tree view
    public $indentTag = 'span';
    public $indentOptions = ['class' => 'indent'];

    private $level = 1;

    public function openTag()
    {
        return Html::beginTag($this->nodeTag, $this->nodeOptions);
    }

    public function closeTag()
    {
        return Html::endTag($this->nodeTag);
    }

    public function simpleList()
    {
        $list = '';

        foreach ($this->model as $item) {
            // Добавляем отступы для элементов
            // Имитация вложенности

            // Исключаем из вывода корень дерева
            if ($item->lft != 0) {
                //$list .= Html::tag($this->itemTag, $this->render('treeview/_item', ['item' => $item]), $this->itemOptions);
                $list .= Html::beginTag($this->itemTag, $this->itemOptions);

                for ($i = 1; $i < $item->lvl; $i++) {
                    $list .= Html::tag($this->indentTag, '', $this->indentOptions);
                }

                $list .= $this->render('treeview/_item', ['item' => $item]);
                $list .= Html::endTag($this->itemTag);
            }
        }
        return $this->openTag() . $list . $this->closeTag();
    }

    public function nestedList()
    {
        $list = '';

        foreach ($this->model as $item) {
            if ($this->level < $item->lvl) {
                $list .= $this->openTag();
            }
            if ($this->level > $item->lvl) {
                $list .= $this->closeTag();
            }
            if ($item->lft != 0) {
                $list .= Html::tag($this->itemTag, $item->name, $this->itemOptions);
            }

            $this->level = $item->lvl;
        }

        for ($i = 1; $i <= $this->level; $i++){
            $list .= $this->closeTag();
		}

        $this->level = 1;
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

        if ($this->treeType == 'simpleList') {
            $this->data['treeView'] = $this->simpleList();
        }

        if ($this->treeType == 'nestedList') {
            $this->data['treeView'] = $this->nestedList();
        }
    }
}

