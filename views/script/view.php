<?php

use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $script app\extended\models\Script */
/* @var $scriptRecent app\extended\models\Script */

$decodedText = json_decode($script->text);
?>

<div class="site-index">
    <div class="body-content">

        <div class="row">

            <div class="col-left col-md-3 tex-center">
                <h2>Скрипты</h2>

                <?php if ($scriptParent) :?>
                    <p>
                        <a class="btn btn-lg btn-danger" href="<?php echo Url::toRoute(['/script/view', 'script' => $scriptParent]);?>">
                            Назад
                        </a>
                    </p>
                <?php endif;?>

                <?php if (isset($scriptRecent)) :?>
                    <?php foreach ($scriptRecent as $recent) :?>

                        <p>
                            <a class="btn btn-lg btn-default" href="<?php echo Url::toRoute(['/script/view', 'script' => $recent->id]);?>">
                                <?php echo $recent->name;?>
                            </a>
                        </p>

                    <?php endforeach;?>
                <?php endif;?>

            </div>

            <div class="col-center col-md-6">
                <h1><?php echo $script->name;?></h1>
                <?php $i = 1;?>
                <?php foreach($decodedText->data as $key => $block) :?>

                    <?php if ($block->type == 'text') :?>
                        <p>
                            <?php echo $block->data->text;?>
                        </p>
                    <?php endif;?>

                    <?php if ($block->type == 'help') :?>
                        <p>
                            <button
                                class="btn btn-info"
                                type="button"
                                data-toggle="collapse"
                                data-target="#collapse<?php echo $i++;?>"
                                aria-expanded="true"
                                aria-controls="collapseOne"
                                data-parent="#accordion">Подсказка</button>
                        </p>
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

            <div class="col-right col-md-3">
                <h2>Подсказки</h2>

                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

                    <?php $i = 1;?>
                    <?php foreach($decodedText->data as $key => $block) :?>
                        <?php if ($block->type == 'help') :?>
                            <div class="panel">
                                <div id="collapse<?php echo $i++;?>" class="panel panel-default panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                    <div class="panel-body">
                                        <?php echo $block->data->text;?>
                                    </div>
                                </div>
                            </div>
                        <?php endif;?>
                    <?php endforeach;?>

                </div>
            </div>

        </div>
    </div>
</div>
