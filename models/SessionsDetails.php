<?php

namespace app\models;

use Yii;

use yii\helpers\Url;

/**
 * This is the model class for table "SessionsDetails".
 *
 * @property integer $id
 * @property integer $sessionId
 * @property integer $scriptId
 * @property string $timeStart
 */
class SessionsDetails extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sessionsDetails';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sessionId', 'scriptId'], 'integer'],
            [['timeStart'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'        => 'ID',
            'sessionId' => 'Идентификатор текущей сессии (звонка)',
            'scriptId'  => 'Идентификатор выбранного перехода',
            'timeStart' => 'Дата и время произведения перехода',
        ];
    }
}
