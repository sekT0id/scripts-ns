<?php

use kartik\date\DatePicker;

use yii\helpers\Html;

use yii\widgets\ListView;
use yii\widgets\LinkSorter;
use yii\widgets\ActiveForm;
?>

<div class="sessions-form">

    <?php $form = ActiveForm::begin([
        'action' => ['/site/view', 'alias' => 'calls'],
        'method' => 'get',
    ]);?>

    <div class="row">
        <div class="col-lg-3">
            <div class="form-group">

            <?php echo $sort->link('timeStart');?>
            <?php echo DatePicker::widget([
                'form' => $form,
                'model' => $model,
                'language' => 'ru',
                'type' => DatePicker::TYPE_RANGE,

                'attribute' => 'timeStart',
                'options' => [
                    'value' => ($model->timeStart) ? $model->timeStart :date('d-m-Y'),
                ],

                'attribute2' => 'dateTo',
                'options2' => [
                    'value' => ($model->dateTo) ? $model->dateTo : date('d-m-Y'),
                ],
                'separator' => '<i class="glyphicon glyphicon-resize-horizontal"></i>',

                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'd-m-yyyy',
                    'todayHighlight' => true,
                ],
            ]);?>

            </div>
        </div>
        <div class="col-lg-3">
            <?php echo $sort->link('phone');?>
            <?php echo $form->field($model, 'phone')->label(false);?>
        </div>
        <div class="col-lg-3">
            <?php echo $sort->link('clientName');?>
            <?php echo $form->field($model, 'clientName')->label(false);?>
        </div>
        <div class="col-lg-3">
            <?php echo $sort->link('comment');?>
            <?php echo $form->field($model, 'comment')->label(false);?>
        </div>
    </div>

    <div class="form-group">
        <?php echo Html::resetButton('Сброс', ['class' => 'btn btn-default']) ?>
        <?php echo Html::submitButton('Поиск', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
echo ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_item',

    'options' => [
        'tag' => 'div',
        'id' => 'accordion',
        'class' => 'accordion',
        'role' => 'tablist',
        'aria-multiselectable' => 'true',
    ],

    'layout' => "{pager}\n{summary}\n{items}\n{pager}",
    'summary' => 'Показано {count} из {totalCount}',
    'summaryOptions' => [
        'tag' => 'span',
        'class' => 'my-summary'
    ],

    'itemOptions' => [
        'tag' => 'div',
        'class' => 'panel panel-default',
    ],

    'emptyText' => '<p>Список пуст</p>',
    'emptyTextOptions' => [
        'tag' => 'p'
    ],

    'pager' => [
        'firstPageLabel' => 'Первая',
        'lastPageLabel' => 'Последняя',
        'nextPageLabel' => 'Следующая',
        'prevPageLabel' => 'Предыдущая',
        'maxButtonCount' => 5,
    ],
]);
