<?php
use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\ActiveForm;
?>

<div class="sessions-form">

    <?php $form = ActiveForm::begin([
        'action' => ['/site/view', 'alias' => 'calls'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'timeStart')?>

    <?= $form->field($model, 'comment')?>
    <?= $form->field($model, 'clientName')?>
    <?= $form->field($model, 'phone')?>

       <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

echo Yii::$app->formatter->asTimestamp(2018);

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
