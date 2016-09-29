<?php

namespace app\widgets;

use Yii;
use yii\data\ActiveDataProvider;
use app\models\Sessions;

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

        $this->getData();

        $this->data['model'] = $this->model;
    }
}
