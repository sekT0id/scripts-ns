<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

NavBar::begin([
    'brandLabel' => 'SmileExpo Scripts',
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar navbar-dark navbar-fixed-top white',
    ],
]);

echo Nav::widget([
    'options' => ['class' => 'nav navbar-nav navbar-right'],
    'items' => [
        ['label' => 'На главную', 'url' => ['/site/index']],
        ['label' => 'Скрипты',    'url' => ['/site/view', 'alias' => 'scripts']],
        ['label' => 'Клиенты',    'url' => ['/site/view', 'alias' => 'clients']],
        ['label' => 'Звонки',     'url' => ['/site/view', 'alias' => 'calls']],
    ],
]);
NavBar::end();
?>
