<?php

/* @var $this yii\web\View */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

use app\widgets\TreeView;

$this->registerJsFile('/libs/nice-tree/src/sekT0id-tree.js', [
    'depends' => 'yii\web\JqueryAsset',
    'position' => $this::POS_END,
]);

$this->registerJsFile('/js/extended-sekT0id-tree.js', [
    'depends' => 'yii\web\JqueryAsset',
    'position' => $this::POS_END,
]);

$this->title = 'My Yii Application';
?>

<div class="site-index">
    <div class="body-content">
        <div class="row">

            <h1>Скрипты</h1>

            <div class="col-md-6 col-md-offset-3">
                <div class="card card-block">
                    <a href="<?php echo Url::toRoute(['script/new']);?>" class="btn btn-default btn-block">
                        Добавить
                    </a>
                </div>
            </div>

            <div class="col-md-6 col-md-offset-3">
                <?php echo TreeView::widget([
                    'treeType' => 'nested',
                    'treeOptions' => [
                        'class' => 'easy-tree card card-block',
                    ],
                    'indentContent' => '<span class="glyphicon glyphicon-option-vertical"></span>',
                    'itemOptions' => [
                        'class' => 'item',
                    ],
                    'nodeOptions' => [
                        'class' => 'node',
                    ],
                ]);?>
            </div>

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
                <p>Выберите скрипт, на который нужно создать ссылку.</p>

                <?php $form = ActiveForm::begin([
                    'action' => ['script/addlink'],
                    'enableClientValidation' => true,
                    'enableAjaxValidation' => false,
                    'options' => ['enctype' => 'multipart/form-data']
                ]);?>

                <?php // id редактируемого скрипта.
                echo $form->field($model, 'parentId')
                    ->hiddenInput(['value' => null])
                    ->label(false);?>

                <?php // id редактируемого скрипта.
                echo $form->field($model, 'id')
                    ->hiddenInput(['value' => null])
                    ->label(false);?>

                <?php echo TreeView::widget([
                    'treeType' => 'modal',
                    'treeOptions' => [
                        'class' => 'easy-tree card card-block',
                    ],
                    'itemOptions' => [
                        'class' => 'item',
                    ],
                    'nodeOptions' => [
                        'class' => 'node',
                    ],
                ]);?>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-dismiss="modal">Отмена</button>

                <?php echo Html::submitButton('Готово', [
                    'id' => 'link-submit',
                    'class' => 'btn btn-default',
                    'disabled' => true,
                ]);?>

                <?php ActiveForm::end();?>
            </div>
        </div>
    </div>
</div>
