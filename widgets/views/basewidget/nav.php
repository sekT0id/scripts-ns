<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

NavBar::begin([
    'brandLabel' => 'My Company',
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar navbar-dark navbar-fixed-top white',
        //'class' => 'navbar navbar-dark navbar-fixed-top bg-primary',
    ],
]);

echo Nav::widget([
    'options' => ['class' => 'nav navbar-nav navbar-right'],
    'items' => [
        ['label' => 'На главную', 'url' => ['/site/index']],
        ['label' => 'Редактор',   'url' => ['/script/new']],
        Yii::$app->user->isGuest ? (
            ['label' => 'Login', 'url' => ['/site/login']]
        ) : (
            '<li>'
            . Html::beginForm(['/site/logout'], 'post', ['class' => 'navbar-form'])
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link']
            )
            . Html::endForm()
            . '</li>'
        )
    ],
]);
NavBar::end();
// http://fezvrasta.github.io/bootstrap-material-design/bootstrap-elements.html
// http://mdbootstrap.com/components/panels/
?>
