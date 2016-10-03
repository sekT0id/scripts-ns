<?php

namespace app\models;

use Yii;
use yii\base\Model;
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
        $query = Sessions::find()->with('details.script')->orderBy('id DESC');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'comment', $this->comment]);
        //$query->andFilterWhere(['like', 'timeStart', Yii::$app->formatter->asTimestamp($this->timeStart)]);

        $query->joinWith(['client' =>
            function ($query) {
                $query->andFilterWhere(['like', Clients::tableName() . '.phone', $this->phone]);
                $query->andFilterWhere(['like', Clients::tableName() . '.name', $this->clientName]);
            }
        ]);

        return $dataProvider;
    }
}
