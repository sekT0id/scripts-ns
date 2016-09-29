<?php
use yii\widgets\ListView;
?>

<?php
echo ListView::widget([
    'dataProvider' => $model,
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
