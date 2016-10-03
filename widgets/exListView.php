<?php

namespace app\widgets;

use Yii;
use yii\data\ActiveDataProvider;

use app\models\Form;
use app\models\Sessions;
use app\models\SessionsSearch;

class exListView extends BaseWidget
{
    public function init()
    {
        parent::init();

        $searchModel = new SessionsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $this->data['model'] = $searchModel;
        $this->data['dataProvider'] = $dataProvider;
    }
}
