<?php

namespace app\controllers;

use Yii;

use app\models\Form;
use app\models\Scripts;
use app\models\Clients;

class SiteController extends BaseController
{

    public function mixinIndex($data)
    {
        $searchModel = new Clients;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $data['searchModel'] = $searchModel;
        $data['dataProvider'] = $dataProvider;

        $data['model'] = new Form;
        $data['data'] = Scripts::find()
        ->andWhere(['lvl' => 1])
        ->all();

        return $data;
    }

    public function mixinScripts($data)
    {
        $data['model'] = new Form;

        return $data;
    }

    public function mixinClients($data)
    {
        $searchModel = new Clients;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $data['searchModel'] = $searchModel;
        $data['dataProvider'] = $dataProvider;

        return $data;
    }

}
