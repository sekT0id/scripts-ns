<?php

use kartik\date\DatePicker;

use yii\helpers\Html;

use yii\widgets\ListView;
use yii\widgets\ActiveForm;
?>

<div class="sessions-form">

    <?php $form = ActiveForm::begin([
        'action' => ['/site/view', 'alias' => 'calls'],
        'method' => 'get',
    ]); ?>

    <div class="row">
        <div class="col-lg-3">
            <div class="form-group">

            <?php echo '<label class="control-label">Даты</label>';?>
            <?php echo DatePicker::widget([
                'form' => $form,
                'model' => $model,
                'language' => 'ru',
                'type' => DatePicker::TYPE_RANGE,

                'attribute' => 'timeStart',
                'attribute2' => 'dateTo',

                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd-m-yyyy',
                    'todayHighlight' => true,
                ],
            ]);?>

            </div>
        </div>
        <div class="col-lg-3">
            <?php echo $form->field($model, 'phone')?>
        </div>
        <div class="col-lg-3">
            <?php echo $form->field($model, 'clientName')?>
        </div>
        <div class="col-lg-3">
            <?php echo $form->field($model, 'comment')?>
        </div>
    </div>

    <div class="form-group">
        <?php echo Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?php echo Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
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
