<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'tableOptions' => [
        'class' => 'table table-hover table-responsive',
    ],
    'rowOptions' => function ($model, $key, $index, $grid) {
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
            'attribute' => 'parent_id',
            'label'     => '',
            'format'    => 'text', // Возможные варианты: raw, html
            'content'   => function ($data) {
//                if ($data->lastSessions) {
//                    return Yii::$app->formatter->asDate(
//                        $data->lastSessions->timeStart
//                    );
//                }
                return '';
            },
            //'filter' => Category::getParentsList()
        ],
        [
            'attribute' => 'name',
            'label'     => 'Наименование',
            'format'    => 'raw',
            'value'     => function ($data) {
                return $data->name;
            }
        ],
        //'name:ntext',
        'phone:ntext',
        'data:ntext',

        //['class' => 'yii\grid\ActionColumn'],
    ],
]);
