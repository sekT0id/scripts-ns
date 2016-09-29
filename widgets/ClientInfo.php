<?php

namespace app\widgets;

use Yii;
use app\models\Clients;

class ClientInfo extends BaseWidget
{
    protected function getData()
    {
        $session = Yii::$app->session;
        $session->open();

        return Clients::getById($session['clientId']);
    }

    public function init()
    {
        parent::init();

        $this->data['client'] = $this->getData();
    }
}
