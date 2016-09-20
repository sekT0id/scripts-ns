<?php

namespace app\models;

use Yii;

use yii\helpers\Url;

/**
 * This is the model class for table "Sessions".
 *
 * @property integer $id
 * @property string $name
 * @property string $data
  */
class Sessions extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sessions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userId', 'clientId', 'timestart'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'        => 'ID',
            'userId'    => 'Идентификатор пользователясистемы',
            'clientId'  => 'Идентификатор клиента',
            'timestart' => 'Дата и время начала сессии',
        ];
    }
    public function start()
    {

        return
    }
}
