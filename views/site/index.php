<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use yii\helpers\Html;

use yii\widgets\ActiveForm;
use app\widgets\Grid;

//use yii\grid\GridView;

$this->title = 'My Yii Application';
?>

<div class="site-index">
    <div class="body-content">
        <div class="row">

            <h1>Начать работу</h1>

            <div class="col-md-6 col-md-offset-3">
                <div class="card card-block">
                    <?php if ($data) :?>
                        <?php foreach ($data as $script) :?>

                                <?php echo Html::tag('button', $script->name, [
                                    'id'    => 'delete-button',
                                    'type'  => 'button',
                                    'class' => 'btn btn-default btn-block',
                                    'data-toggle' => 'modal',
                                    'data-target' => '#myModal',
                                    'onClick' => "$('#form-id').val($script->id)",
                                ]);?>

                        <?php endforeach;?>
                    <?php endif;?>
                </div>
            </div>

        </div>
    </div>
</div>

<?php if ($data) :?>
    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Выберите клиента</h4>
                </div>
                <div class="modal-body">

                    <?php \yii\widgets\Pjax::begin();?>
                        <?php echo grid::widget();?>
                    <?php \yii\widgets\Pjax::end();?>

                </div>
                <div class="modal-footer">

                    <?php $form = ActiveForm::begin([
                        'action' => ['/script/view'],
                        'enableClientValidation' => true,
                        'enableAjaxValidation' => false,
                        'options' => ['enctype' => 'multipart/form-data']
                    ]);?>

                    <?php // id редактируемого скрипта.
                    echo $form->field($model, 'id')
                        ->hiddenInput(['value' => null])
                        ->label(false);?>

                    <?php echo $form->field($model, 'clientId')
                        ->hiddenInput(['value' => null])
                        ->label(false);?>

                        <button type="button" class="btn btn-warning" data-dismiss="modal">Отмена</button>

                        <?php echo Html::submitButton('Начать', [
                            'class' => 'btn btn-default',
                        ]);?>
                    <?php ActiveForm::end();?>

                </div>
            </div>
        </div>
    </div>
<?php endif;?>
