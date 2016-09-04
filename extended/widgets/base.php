<?php

namespace app\extended\widgets;

use Yii;
use yii\base\Widget;

/**
 * Базовый виджет, реализующий основной функционал.
 */
class Base extends Widget
{
    protected $_name = null;

    public $show = 'default';

    /* Содержимое этого массива будет передано в представление */
    public $data = [];


    /**
     * В ходе инициализации $_name будет = имени класса, приведенного к нижнему регистру
     */
    public function init()
    {
        $name = explode('\\', self::className());
        $this->_name = strtolower(end($name));
        parent::init();
    }

    public function run()
    {
        $path = $this->_name . DIRECTORY_SEPARATOR . $this->show;

        /**
         * Ищем пользовательское представление
         */
        if (file_exists(Yii::$app->basePath . "/widgets/views" . DIRECTORY_SEPARATOR . $path . '.php')) {
            return $this->render("@app/widgets/views/" . $path, $this->data);
        // Если его нет - отрисовываем представление прототипа
        } elseif (file_exists($this->viewPath . DIRECTORY_SEPARATOR . $path . '.php')) {
            return $this->render($path, $this->data);
        // Если нет и его - отрисовывает стандартное представление для всех виджетов (лог)
        } else {
            return $this->render('default', $this->data);
        }
    }
}
