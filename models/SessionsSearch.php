<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\Sort;
use yii\data\ActiveDataProvider;
use app\models\Sessions;

/**
 * SessionsSearch represents the model behind the search form about `app\models\Sessions`.
 */
class SessionsSearch extends Sessions
{
    public $phone = null;
    public $clientName = null;
    public $dateTo = null;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'userId', 'clientId'], 'integer'],
            [['comment', 'timeStart', 'dateTo', 'phone', 'clientName'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'phone'  => 'Номер телефона',
            'comment' => 'Комментарий',
            'clientName' => 'Наименование клиента',
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
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
        $sort = new Sort([
            'attributes' => [
                'timeStart',
                'comment',
                'phone' => [
                    'asc' => [Clients::tableName() . '.phone' => SORT_ASC],
                    'desc' => [Clients::tableName() . '.phone' => SORT_DESC],
                    'default' => SORT_DESC,
                    'label' => $this->attributeLabels()['phone'],
                ],
                'clientName' => [
                    'asc' => [Clients::tableName() . '.name' => SORT_ASC],
                    'desc' => [Clients::tableName() . '.name' => SORT_DESC],
                    'default' => SORT_DESC,
                    'label' => $this->attributeLabels()['clientName'],
                ],
            ],
        ]);

        $query = Sessions::find()
            ->with('details.script');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => $sort,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'comment', $this->comment]);
        $query->andFilterWhere([
            'between',
            'timeStart',
            Yii::$app->formatter->asTimestamp($this->timeStart),
            Yii::$app->formatter->asTimestamp($this->dateTo . '+1 day'),
        ]);

        $query->joinWith(['client' =>
            function ($query) {
                $query->andFilterWhere(['like', Clients::tableName() . '.phone', $this->phone]);
                $query->andFilterWhere(['like', Clients::tableName() . '.name', $this->clientName]);
            }
        ]);

        return $dataProvider;
    }
}
