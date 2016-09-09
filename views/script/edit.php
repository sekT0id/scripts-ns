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

            <h1>Редактор скрипта</h1>

            <?php $form = ActiveForm::begin([
                'action' => ['script/save'],
                'enableClientValidation' => true,
                'enableAjaxValidation' => false,
                'options' => ['enctype' => 'multipart/form-data']
            ]);?>

                <div class="col-md-6 col-md-offset-3">

                    <div class="card card-block">

                        <?php // id редактируемого скрипта.
                        echo $form->field($model, 'id')
                            ->hiddenInput(['value' => ($script) ? $script->id : false])
                            ->label(false);?>
                        <?php // id редактируемого скрипта.
                        echo $form->field($model, 'parentId')
                            ->hiddenInput(['value' => ($parentId) ? $parentId : null])
                            ->label(false);?>
                        <?php echo $form->field($model, 'name')
                            ->input('text', [
                                'value' => ($script) ? $script->name : false,
                            ])
                            ->label('Имя скрипта *') ?>

                    </div>

                    <?php // Подключаем поле для редактора Sir Trevor
                    echo $form->field($model, 'text')
                        ->textArea([
                            'id' => 'sir-trevor-textArea',
                            'class' => 'js-st-instance',
                            'value' => ($script) ? $script->data : false,
                        ])
                        ->label(false);
                    ?>

                </div>

                <div class="col-md-2">

                    <div class="card card-block text-center">

                        <?php echo Html::submitButton('Сохранить', [
                            'class' => 'btn btn-fixed btn-success',
                        ]);?>
                        <?php echo Html::tag('a', 'Отмена', [
                            'class' => 'btn btn-fixed btn-warning',
                            'href' => Url::toRoute(['site/index']),
                        ]);?>

                    </div>

                    <?php if ($script) :?>
                        <div class="card">
                           <div class="card-block bg-danger text-center">

                                <?php echo Html::tag('button', 'Удалить', [
                                    'id'    => 'delete-button',
                                    'type'  => 'button',
                                    'class' => 'btn btn-fixed btn-danger',
                                    'data-toggle' => 'modal',
                                    'data-target' => '#myModal',
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
                <p>Удаление скрипта приведет к удалению всех дочерних(вложенных) скриптов, а также ссылок на него.</p>
            </div>
            <div class="modal-footer">

                <?php $form = ActiveForm::begin([
                    'action' => ['script/delete'],
                    'enableClientValidation' => true,
                    'enableAjaxValidation' => false,
                    'options' => ['enctype' => 'multipart/form-data']
                ]);?>

                <?php // id редактируемого скрипта.
                echo $form->field($model, 'id')
                    ->hiddenInput(['value' => ($script) ? $script->id : false])
                    ->label(false);?>

                    <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>

                    <?php echo Html::submitButton('Удалить', [
                        'class' => 'btn btn-danger',
                    ]);?>
                <?php ActiveForm::end();?>

            </div>
        </div>
    </div>
</div>
