<?php

use yii\helpers\Url;
use yii\helpers\Html;

use app\widgets\ClientInfo;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $script app\extended\models\Script */
/* @var $scriptRecent app\extended\models\Script */

$decodedText = json_decode($script->data);
?>

<div class="site-index">
    <div class="body-content">

        <div class="row">

            <h1><?php echo $script->name;?></h1>

            <div class="col-md-8 col-md-offset-2">
                <?php echo ClientInfo::widget();?>

                <div class="card card-block">

                    <?php foreach ($decodedText->data as $key => $block) :?>

                        <?php if ($block->type == 'text') :?>
                            <?php echo $block->data->text;?>
                        <?php endif;?>

                        <?php if ($block->type == 'list') :?>
                            <ul>
                                <?php foreach ($block->data->listItems as $key => $value) :?>
                                   <li><?php echo $value->content;?></li>
                                <?php endforeach;?>
                            </ul>
                        <?php endif;?>

                    <?php endforeach;?>

                </div>

                <div class="card card-block">

                    <?php if (isset($scriptRecent) && $scriptRecent = []) :?>

                        <?php foreach ($scriptRecent as $recent) :?>
                            <a
                                class="btn btn-default btn-block"
                                href="<?php echo Url::toRoute([
                                    '/script/view',
                                    'script' => ($recent->link) ? $recent->link : $recent->id
                                ]);?>"
                            >
                                <?php echo $recent->name;?>
                            </a>
                        <?php endforeach;?>

                    <?php else :?>
                        <?php $session = Yii::$app->session;?>
                        <?php if (isset($session['sessionId'])) :?>

                            <?php $form = ActiveForm::begin([
                                'action' => ['session/save'],
                                'enableClientValidation' => true,
                                'enableAjaxValidation' => false,
                                'options' => ['enctype' => 'multipart/form-data']
                            ]);?>

                                <?php echo $form->field($model, 'comment')
                                    ->textArea([
                                        'autofocus' => 'autofocus',
                                        'rows' => 3,
                                    ]);?>

                                <?php echo $form->field($model, 'id')
                                    ->hiddenInput(['value' => $session['sessionId']])
                                    ->label(false);?>

                                <?php echo Html::tag('button', 'Завершить', [
                                    'id'    => 'delete-button',
                                    'type'  => 'submit',
                                    'class' => 'btn btn-warning btn-block',
                                ]);?>

                            <?php ActiveForm::end();?>

                        <?php else :?>
                            <a class="btn btn-warning btn-block" href="<?php echo Url::toRoute(['/site/index']);?>">
                                Завершить
                            </a>
                        <?php endif;?>

                    <?php endif;?>

                </div>
            </div>

        </div>
    </div>
</div>
