<?php

namespace app\models;

use Yii;

use yii\helpers\Url;

/**
 * This is the BaseModel class.
 */
class BaseModel extends \yii\db\ActiveRecord
{
    /**
     * Ищет запись по id.
     *
     * @var int $scriptId
     * @return object / boolean
     */
    public static function getById($searchedId = null)
    {
        return self::find()->where(['id' => $searchedId])->one();
    }

    /**
     * Задаем для всех типов запросов дополнительную
     * фильтрацию по id пользователя
     *
     * @return ActiveRecord object
     */
    public static function find()
    {
        return parent::find()->andWhere(['userId' => self::getUserId()]);
    }

    /**
     * Автоматическая запись данных в поля
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            // id текущего пользователя
            if ($this->hasAttribute('userId')) {
                $this->userId = self::getUserId();
            }
            // Дата и время начала действия
            if ($this->hasAttribute('timeStart')) {
                $this->timeStart = Yii::$app->formatter->asTimestamp(date('Y-d-m h:i:s'));
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * Возвращает информацию о текущем залогиненом пользователе.
     *
     * @return ActiveRecord object
     */
    public static function getUserId()
    {
        $user = Yii::$app->get('user', false);
        return $user && !$user->isGuest ? $user->id : null;
    }
}
