<?php

namespace app\widgets;

use Yii;
use app\models\Clients;

class Grid extends BaseWidget
{
    public $pageSize = 10;
    public $model = null;

    public function init()
    {
        parent::init();

        if ($this->model === null) {
            $this->model = new Clients;
        }

        //$searchModel = new Clients;
        $searchModel = $this->model;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->defaultPageSize = $this->pageSize;

        $this->data['searchModel'] = $searchModel;
        $this->data['dataProvider'] = $dataProvider;
    }
}
