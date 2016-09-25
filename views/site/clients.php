<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use yii\helpers\Html;

use yii\grid\GridView;

$this->title = 'My Yii Application';
?>

<div class="site-index">
    <div class="body-content">
        <div class="row">

            <h1>Начать работу</h1>

            <div class="col-md-6 col-md-offset-3">
                <div class="card card-block">
                    <a href="<?php echo Url::toRoute(['client/new']);?>" class="btn btn-default btn-block">
                        Добавить
                    </a>
                </div>
            </div>

            <div class="col-md-6 col-md-offset-3">
                <div class="card card-block">
                    <?php echo GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            //['class' => 'yii\grid\SerialColumn'],
                            [
                                'attribute' => 'hasSession',
                                'label' => '123',
                                'format' => 'text', // Возможные варианты: raw, html

                                'content' => //function($data) {
                                    function ($model, $index, $widget) {
                                        return Html::checkbox('foo[]', $model->hasSession, ['value' => $index, 'disabled' => true]);
                                    }
//                                    if ($data->hasSession) {
//                                        return $data->hasSession;
//                                        return '+++';
//                                    }
//                                    return '---';
//                                },

//                                'filter' => [
//                                    'true' => 'yes',
//                                    'false' => 'no',
//                                ],
                            ],
                            [
                                'attribute' => 'name',
                                'label' => 'Наименование',
                                'format' => 'raw',
                                'value' => function($data) {
                                    return $data->name;
                                }
                            ],
                            //'name:ntext',
                            'phone:ntext',
                            'data:ntext',

                            //['class' => 'yii\grid\ActionColumn'],
                        ],
                    ]);?>
                </div>
            </div>

        </div>
    </div>
</div>
