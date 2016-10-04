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
}
