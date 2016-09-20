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
            [['userId', 'clientId'], 'integer'],
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
            'userId'    => 'Идентификатор пользователясистемы',
            'clientId'  => 'Идентификатор клиента',
            'timeStart' => 'Дата и время начала сессии',
        ];
    }
    public function start()
    {
        // Запускаем транзакцию, так как будем выполнять
        // достаточно объемные работы
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $this->insert();
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
        return $this->id;
    }
}
