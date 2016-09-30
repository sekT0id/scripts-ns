<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'summary' => 'Показано {count} из {totalCount}',
    'columns' => [
        //['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'startTime',
            'label' => 'Дата звонка',
            'format' => 'date',

            'content' =>
                function ($model) {
                    return Yii::$app->formatter->asDate($model->timeStart);
                },

            'contentOptions' => [
                'class' => 'text-center',
            ],
        ],
        [
            'attribute' => 'phone2',
            'label' => 'Номер телефона',
            'format' => 'text',

            'content' =>
                function ($model) {
                    return $model->client->phone;
                },

            'contentOptions' => [
                'class' => 'text-center',
            ],
        ],
        'phone',
        [
            'attribute' => 'startTime',
            'label' => 'Номер телефона',
            'format' => 'text',

            'content' =>
                function ($model) {
                    return $model->client->name;
                },

            'contentOptions' => [
                'class' => 'text-center',
            ]
        ],
        'comment:ntext',
    ],
]);
