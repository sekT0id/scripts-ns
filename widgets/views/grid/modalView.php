<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'tableOptions' => [
        'class' => 'table table-hover table-responsive table-modal',
    ],
    'rowOptions' => function ($model) {
        return [
            'id' => $model['id'],
            'onclick' =>"
                $('tr').removeClass('btn-default');
                $(this).toggleClass('btn-default');
                $('#form-clientid').val(".$model['id'].");"
            ];
    },
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
                    return Html::a($icon, 'tel:'.$model->phone);
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
        [
            'attribute' => 'phone',
            'format' => 'text',
            'content' =>
                function ($model) {
                    return Html::a($model->phone, 'tel:'.$model->phone);
                }
        ],
        'data:ntext',

        //['class' => 'yii\grid\ActionColumn'],
    ],
]);
