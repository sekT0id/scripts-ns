<?php

/* @var $this yii\web\View */

use yii\helpers\Url;
use yii\helpers\Html;

use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput
?>

<div class="site-index">
    <div class="body-content">

        <div class="row">

            <h1>Клиентская информация</h1>

            <?php $form = ActiveForm::begin([
                'action' => ['client/save'],
                'enableClientValidation' => true,
                'enableAjaxValidation' => false,
                'options' => ['enctype' => 'multipart/form-data']
            ]);?>

                <div class="col-md-8 col-md-offset-2">
                    <div class="card card-block">

                        <?php echo $form->field($model, 'id') // id редактируемого клиента.
                            ->hiddenInput(['value' => ($data) ? $data->id : false])
                            ->label(false);?>

                        <?php echo $form->field($model, 'name')
                            ->input('text', [
                                'value' => ($data) ? $data->name : false,
                                'autofocus' => 'autofocus',
                            ])
                            ->label($model->getAttributeLabel('name') . ' *');?>

                        <?php echo $form->field($model, 'phone')
                            ->widget(MaskedInput::className(), [
                                'mask' => '+9 (999) 999-99-99',
                                'options' => [
                                    'value' => ($data) ? $data->phone : false,
                                ],
                            ])
                            ->label($model->getAttributeLabel('phone') . ' *');?>

                        <?php echo $form->field($model, 'data')
                            ->textArea([
                                'rows' => 8,
                                'value' => ($data) ? $data->data : false,
                            ]);?>

                    </div>
                </div>

                <div class="col-md-8 col-md-offset-2">
                    <div class="card card-block text-center">

                        <?php echo Html::submitButton('Сохранить', [
                            'class' => 'btn btn-fixed btn-success',
                        ]);?>
                        <?php echo Html::tag('a', 'Отмена', [
                            'class' => 'btn btn-fixed btn-warning',
                            'href' => Url::toRoute(['site/view', 'alias' => 'clients']),
                        ]);?>

                        <?php if ($data) :?>
                                <?php echo Html::tag('button', 'Удалить', [
                                    'id'    => 'delete-button',
                                    'type'  => 'button',
                                    'class' => 'btn btn-fixed btn-danger',
                                    'data-toggle' => 'modal',
                                    'data-target' => '#myModal',
                                ]);?>
                        <?php endif;?>

                    </div>
                </div>

            <?php ActiveForm::end();?>

        </div>
    </div>
</div>

<?php if ($data) :?>
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
                    <p>Подтвердите необратимое действие - Удаление клиента <b>"<?php echo $data->name;?>"</b></p>
                </div>
                <div class="modal-footer">

                    <?php $form = ActiveForm::begin([
                        'action' => ['client/delete'],
                        'enableClientValidation' => true,
                        'enableAjaxValidation' => false,
                        'options' => ['enctype' => 'multipart/form-data']
                    ]);?>

                    <?php // id редактируемого скрипта.
                    echo $form->field($model, 'id')
                        ->hiddenInput(['value' => $data->id])
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
<?php endif;?>
