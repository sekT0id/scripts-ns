<?php

namespace app\controllers;

use Yii;

use app\models\Form;
use app\models\Scripts;

class SiteController extends BaseController
{

    public function mixinIndex($data)
    {
        $data['scripts'] = Scripts::find()
        ->where(['lvl' => 1])
        ->all();

        return $data;
    }

    public function mixinScripts($data)
    {
        $data['model'] = new Form;

        return $data;
    }

}
