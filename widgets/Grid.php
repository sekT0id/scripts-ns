<?php

namespace app\widgets;

use Yii;
use app\models\Clients;

class Grid extends BaseWidget
{
    public function init()
    {
        parent::init();

        $searchModel = new Clients;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $this->data['searchModel'] = $searchModel;
        $this->data['dataProvider'] = $dataProvider;
    }
}
