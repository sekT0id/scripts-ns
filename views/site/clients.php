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
                                'attribute'=>'name',
                                'label' => 'Наименование',
                                'format' => 'raw',
                                'value' => function($data){
                                    return Html::a(
                                        $data->name,
                                        Url::toRoute(['/client/edit', 'clientId' => $data->id])
                                    );
                                }
                            ],
                            [
                                'attribute'=>'parent_id',
                                'label'=>'Родительская категория',
                                'format'=>'text', // Возможные варианты: raw, html
                                'content'=>function($data){
                                    if ($data->hasSessions()) {
                                        return 'ok';
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
                    ]);?>
                </div>
            </div>

        </div>
    </div>
</div>
