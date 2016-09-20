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
                $('#clientId').val(".$model['id'].");"
            ];
    },
    'columns' => [
        //['class' => 'yii\grid\SerialColumn'],
        [
            'attribute'=>'name',
            'label' => 'Наименование',
            'format' => 'raw',
            'value' => function ($data) {
                return Html::a(
                    $data->name,
                    Url::toRoute(['/client/edit', 'clientId' => $data->id])
                );
            }
        ],
        [
            'attribute' => 'parent_id',
            'label'     => 'Родительская категория',
            'format'    => 'text', // Возможные варианты: raw, html
            'content'   => function ($data) {
                if ($data->sessions()) {
                    foreach ($data->sessions() as $session) {
                        return $session;
                    }
                }
                return 'nope';
            },
            //'filter' => Category::getParentsList()
        ],
        //'name:ntext',
        'phone:ntext',
        'data:ntext',

        //['class' => 'yii\grid\ActionColumn'],
    ],
]);
