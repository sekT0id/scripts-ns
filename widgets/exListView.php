<?php

namespace app\widgets;

use Yii;
use yii\data\ActiveDataProvider;

use app\models\Form;
use app\models\Sessions;
use app\models\SessionsSearch;

class exListView extends BaseWidget
{
    public $pageSize = 10;

    protected function getData()
    {
        $this->model = new ActiveDataProvider([
            'query' => Sessions::find()
                ->with('details.script')
                ->orderBy('id DESC'),
            'pagination' => [
                'pageSize' => $this->pageSize,
            ],
        ]);
    }

    public function init()
    {
        parent::init();

        //$this->getData();
        //$this->data['searchModel'] = $this->model;

        $searchModel = new SessionsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $this->data['model'] = $searchModel;
        //$this->data['searchModel'] = $searchModel;
        $this->data['dataProvider'] = $dataProvider;
    }
}
