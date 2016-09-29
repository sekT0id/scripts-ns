<?php

namespace app\models;

use Yii;

use yii\helpers\Url;

use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "Sessions".
 *
 * @property integer $id
 * @property integer $userId
 * @property integer $clientId
 * @property string $timeStart
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
            [['timeStart', 'comment'], 'string'],
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
            'comment'   => 'Комментарий к звонку',
            'timeStart' => 'Дата и время начала сессии',
        ];
    }

    /**
     * создает новую запись
     * и возвращает её идентификатор.
     *
     * @return int (inserted id)
     */
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

    /**
     * Relation function
     *
     * @return ActiveRecord object
     */
    public function getClient()
    {
        return $this->hasOne(Clients::className(), ['id' => 'clientId']);
    }

    /**
     * Relation function
     *
     * @return ActiveRecord object
     */
    public function getDetails()
    {
        return $this->hasMany(SessionsDetails::className(), ['sessionId' => 'id']);
    }
}
