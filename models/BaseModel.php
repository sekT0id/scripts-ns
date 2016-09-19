<?php

namespace app\models;

use Yii;
use yii\helpers\Url;

/**
 * This is the BaseModel class.
 */
class BaseModel extends \yii\db\ActiveRecord
{
    public static $userId = true;

    public static function find()
    {
        if (self::$userId) {
            return parent::find()->andWhere(['userId' => Yii::$app->user->id]);
        }
        return parent::find();
    }
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
}
