<?php

/* @var $this yii\web\View */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\Json;

use yii\web\JsExpression;
use yii\widgets\ActiveForm;

$this->registerJsFile('/libs/sir-trevor/sir-trevor.min.js', [
    'depends' => 'yii\web\JqueryAsset',
    'position' => $this::POS_END,
]);

$this->registerJsFile('/js/extended-sir-trevor.js', [
    'depends' => 'yii\web\JqueryAsset',
    'position' => $this::POS_END,
]);
?>

<div class="site-index">
    <div class="body-content">

        <div class="row">

            <?php $form = ActiveForm::begin([
                'action' => ['script/save'],
                'enableClientValidation' => true,
                'enableAjaxValidation' => false,
                'options' => ['enctype' => 'multipart/form-data']
            ]);?>

                <div class="col-center col-md-9">
                    <h1>Редактор скрипта</h1>

                    <?php // Подключаем поле для редактора Sir Trevor
                    echo $form->field($model, 'text')
                        ->textArea([
                            'id' => 'sir-trevor-textArea',
                            'class' => 'js-st-instance',
                            'value' => (isset($script)) ? $script->text : false,
                        ])
                        ->label(false);
                    ?>

                </div>

                <div class="col-right col-md-3 text-center">
                    <h2>Настройки</h2>

                    <div class="panel panel-default">
                        <div class="panel-body">

                            <?php echo $form->field($model, 'name')
                                ->input('text', [
                                    'value' => (isset($script)) ? $script->name : false,
                                ])
                                ->label('Имя скрипта *') ?>

                            <?php
                            // Формируем подсказку для поля parentId
                            $hint = Html::tag('span', '', [
                                'class'          => 'glyphicon glyphicon-question-sign cursor-help pull-right',
                                'aria-hidden'    => 'true',
                                'data-toggle'    => 'tooltip',
                                'data-placement' => 'top',
                                'title' =>
                                    "Нет (Значение по умолчанию) - Независимый, либо родительский скрипт.\n".
                                    "<Имя скрипта> - Скрипт будет доступен в меню выбранного скрипта.\n",
                            ]);

                            // Формируем итемы для поля path
                            $parentIdItems = [];
                            foreach ($scripts as $scr) {
                                $path = '';
                                if ($scr->path != '') {
                                    $path = $scr->path.'.';
                                }

                                $path .= $scr->id ;
                                $parentIdItems[$path] = $scr->name;
                            }

                            echo $form->field($model, 'path')
                                ->dropdownList(
                                    $parentIdItems,
                                    [
                                        'prompt' => '-- Нет --',
                                        'options' => [
                                            (isset($script)) ? $script->path : false => [
                                                'Selected' => true,
                                            ],
                                        ],
                                    ]
                                )
                                ->label('Родительский скрипт '.$hint);?>

                            <?php // id редактируемого скрипта.
                            echo $form->field($model, 'id')
                                ->hiddenInput(['value' => (isset($script)) ? $script->id : false])
                                ->label(false);?>

                            <?php echo Html::submitButton('Сохранить', [
                                'class' => 'btn btn-success',
                            ]);?>

                            <?php echo Html::tag('a', 'Отмена', [
                                'class' => 'btn btn-warning',
                                'href' => Url::toRoute(['site/index']),
                            ]);?>

                        </div>
                    </div>

                    <?php if (isset($script->id)) :?>
                        <div class="panel panel-danger">
                            <div class="panel-body bg-danger">

                                <?php echo Html::tag('button', 'Удалить', [
                                    'id'    => 'delete-button',
                                    'type'  => 'button',
                                    'class' => 'btn btn-danger',
                                    'data-toggle' => 'modal',
                                    'data-target' => '#myModal',
                                    //'href'  => Url::toRoute(['script/delete', 'script' => $script->id]),
                                ]);?>

                            </div>
                        </div>
                    <?php endif;?>

                </div>
            <?php ActiveForm::end();?>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Подтверждение удаления</h4>
            </div>
            <div class="modal-body">
                <p>Удаление скрипта приведет к удалению всех дочерних(вложенных) скриптов.</p>

                <?php $form = ActiveForm::begin([
                    'action' => ['script/delete'],
                    'enableClientValidation' => true,
                    'enableAjaxValidation' => false,
                    'options' => ['enctype' => 'multipart/form-data']
                ]);?>

                <?php // id редактируемого скрипта.
                    echo $form->field($model, 'id')
                        ->hiddenInput(['value' => (isset($script)) ? $script->id : false])
                        ->label(false);?>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                <?php echo Html::submitButton('Удалить', [
                    'class' => 'btn btn-danger',
                ]);?>
                <?php ActiveForm::end();?>
            </div>
        </div>
    </div>
</div>
