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

    public static function find()
    {
        return parent::find()->andWhere(['userId' => self::getUserId()]);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->hasAttribute('userId')) {
                $this->userId = self::getUserId();
            }
            if ($this->hasAttribute('timeStart')) {
                $this->timeStart = Yii::$app->formatter->asTimestamp(date('Y-d-m h:i:s'));
            }
            if ($this->hasAttribute('hasSession')) {
                $this->hasSession = true;
            }
            return true;
        } else {
            return false;
        }
    }

    public static function getUserId()
    {
        $user = Yii::$app->get('user', false);
        return $user && !$user->isGuest ? $user->id : null;
    }
}
