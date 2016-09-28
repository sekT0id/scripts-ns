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
            'attribute' => 'hasSession',
            'label' => 'Звонки',
            'format' => 'text', // Возможные варианты: raw, html

            'content' =>
                function ($model) {
                    $icon = '';
                    if ($model->hasSession) {
                        $icon = '<span class="glyphicon glyphicon-phone-alt text-muted" aria-hidden="true"></span>';
                    } else {
                        $icon = '<span class="glyphicon glyphicon-phone-alt text-primary" aria-hidden="true"></span>';
                    }
                    return $icon;
                },

            'contentOptions' => [
                'class' => 'text-center',
            ],

            'filter' => [
                '1' => 'Был звонок',
                '0' => 'Еще не звонили',
            ],
        ],
        'name:ntext',
        'phone:ntext',
        'data:ntext',
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update}',
            'buttons' => [
                'update' =>
                    function ($url, $model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-pencil"></span>',
                            Url::toRoute(['client/edit', 'clientId' => $model->id])
                        );
                    },
            ],
        ]
    ],
]);
