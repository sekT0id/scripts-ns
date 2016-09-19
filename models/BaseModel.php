<?php

namespace app\models;

use Yii;

use yii\helpers\Url;

use yii\behaviors\BlameableBehavior;
use app\behaviors\setUserId;

/**
 * This is the BaseModel class.
 */
class BaseModel extends \yii\db\ActiveRecord
{
    public $userId;
    private static $uId = false;

    public function behaviors()
    {
        return [
            [
                'class' => setUserId::className(),
                'createdByAttribute' => 'userId',
                'updatedByAttribute' => false,
            ],

        ];
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

    public function init()
    {
        self::$uId = $this->userId;
    }

    public static function find()
    {
        return parent::find()->andWhere(['userId' => Yii::$app->user->id]);
    }
}
