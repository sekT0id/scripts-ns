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
 * @property integer $link
 * @property string $name
 * @property string $data
  */
class BaseModel extends \yii\db\ActiveRecord
{
    /**
     * Ищет запись по id.
     *
     * @var int $scriptId
     * @return boolean / object
     */
    public static function getById($id = null)
    {
        if ($id !== null) {
            return self::find()->andWhere(['id' => $id])->one();
        }
        return false;
    }
}
