<?php

namespace app\models;

use Yii;
use yii\helpers\Url;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "clients".
 *
 * @property integer $id
 * @property string $name
 * @property string $data
 */
class Clients extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'clients';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'phone', 'data'], 'string'],
            [['name'], 'string', 'max' => 150],
            [['userId'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'      => 'ID',
            'userId'  => 'userID',
            'name'    => 'Наименование',
            'phone'   => 'Телефон',
            'data'    => 'Дополнительная информация',
        ];
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = self::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'data', $this->data]);

        return $dataProvider;
    }

    public function sessions(){
        if ($this->hasMany(Sessions::className(), ['cliendId' => $this->id])) {
            return true;
        }
        return false;
    }
}
