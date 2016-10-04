<?php

namespace app\widgets;

use Yii;
use yii\helpers\Html;
use app\models\Scripts;
use yii\base\InvalidConfigException;

class TreeView extends BaseWidget
{
    // Тип отрисовки дерева
    public $treeType = 'default';
    public $treeOptions = [
        'id' => 'tree',
    ];

    // Тэг отступа для simpleList
    public $indentTag = 'span';
    public $indentContent = '';
    public $indentOptions = ['class' => 'indent'];

    // Параметры тега обертки
    public $nodeTag = 'ul';
    public $nodeOptions = [];

    // Параметры тега элемента
    public $itemTag = 'li';
    public $itemOptions = [];
    public $itemTemplate = 'item';

    // Параметры для элемента "ссылка на скрипт"
    public $linkTemplate = 'link';

    private $level = 0;

    /**
     * Возвращает html строку параметров тега
     *
     * @return string / exception
     */
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
     * Формирует открывающий тег для ноды
     *
     * @return string
     */
    public function nodeOpenTag()
    {
        return Html::beginTag($this->nodeTag, $this->nodeOptions);
    }

    /**
     * Формирует закрывающий тег для ноды
     *
     * @return string
     */
    public function nodeCloseTag()
    {
        return Html::endTag($this->nodeTag);
    }

    /**
     * Формирует открывающий тег для элемента
     *
     * @return string
     */
    public function itemOpenTag()
    {
        return Html::beginTag($this->itemTag, $this->itemOptions);
    }

    /**
     * Формирует закрывающий тег для элемента
     *
     * @return string
     */
    public function itemCloseTag()
    {
        return Html::endTag($this->itemTag);
    }

    /**
     * Возвращает отрендереный элемент
     *
     * @var string $viewName
     * @var array $options
     *
     * @return Exception / boolean / string
     */
    public function renderItem($viewName = null, $options = [])
    {
        $path = Yii::$app->basePath . '/widgets/views/treeview/' . $this->treeType . '/' . $viewName . '.php';

        if ($viewName !== null) {
            if (file_exists($path)) {
                return $this->render("@app/widgets/views/treeview/" . $this->treeType . '/' . $viewName, $options);
            }
            return false;
        }
        throw new InvalidConfigException('Необходимо задать имя view файла');
    }

    /**
     * Формируем простое дерево (default)
     *
     * SQL - order by 'left' attribute for Nested Sets
     * SQL - order by PK for other '2D' sets
     *
     * @return string
     */
    public function getSimpleTree()
    {
        $output = '';

        foreach ($this->model as $item) {

            // Исключаем из вывода корень дерева
            if ($item->lft != 0) {

                // Открываем тэг элемента
                $output .= $this->itemOpenTag();

                // Добавляем отступы
                for ($i = 1; $i < $item->lvl; $i++) {
                    $output .= Html::tag($this->indentTag, $this->indentContent, $this->indentOptions);
                }

                // Рендерим контент элемента из вьюшки
                $output .= $this->renderItem($this->itemTemplate, ['item' => $item]);

                // закрываем тег элемента
                $output .= $this->itemCloseTag();
            }
        }
        return $this->nodeOpenTag() . $output . $this->nodeCloseTag();
    }

    /**
     * Формируем сложное вложенное дерево
     * на основе набора Nested Sets
     *
     * SQL - order by 'left' attribute
     *
     * @return string
     */
    public function getNestedTree()
    {
        $output = '';

        foreach ($this->model as $item) {

            // Исключаем из вывода корень дерева
            if ($item->lft != 0) {

                // Если уровень уменьшился, то закрываем теги
                if ($this->level > $item->lvl) {
                    // Разница в уровнях
                    // Чтобы отслеживать резкие перепады вложенности
                    $lvlDifference = $this->level - $item->lvl;

                    // Закрываем открытые элементы в зависимости
                    // от разности уровня
                    for ($i=1; $i<=$lvlDifference; $i++) {
                        $output .= $this->nodeCloseTag();
                        $output .= $this->itemCloseTag();
                    }
                }

                // Если уровень увеличился, то открываем
                // новую ноду.
                if ($this->level < $item->lvl) {
                    $output .= $this->nodeOpenTag();
                }

                // Формируем элемент дерева
                $output .= $this->itemOpenTag();

                // Для элемента ссылки и обычного элемента
                // выбираем свою вьюшку для отображения
                if ($item->link) {
                    $output .= $this->renderItem($this->linkTemplate, ['item' => $item]);
                } else {
                    $output .= $this->renderItem($this->itemTemplate, ['item' => $item]);
                }
            }
            // Закрыв при необходимости все открытые теги,
            // уравниваем уровни виджета и набора Nested Sets
            $this->level = $item->lvl;
        }

        // Если закончили отрисовку дерева не на первом
        // уровне, то закрываем необходимое количество тегов
        for ($i = 1; $i < $this->level; $i++) {
            $output .= $this->nodeCloseTag();
            $output .= $this->itemCloseTag();
        }
        return $output;
    }

    /**
     * init function
     *
     * @return string
     */
    public function init()
    {
        parent::init();

        if ($this->model == null) {
            $this->model = Scripts::find()
                ->orderBy('lft')
                ->all();
        }

        if (!$this->model) {
            $this->show = 'empty';
        }

        // Разбираем опции для тега дерева
        $this->data['treeOptions'] = $this->getTreeOptions();

        // Выбираем вариант отображения
        // Простое дерево (по умолчанию)
        if ($this->treeType == 'default') {
            $this->data['treeView'] = $this->getSimpleTree();
        }

        // Дерево на основе набора Nested Sets
        if ($this->treeType != 'default') {
            $this->data['treeView'] = $this->getNestedTree();
        }
    }
}
