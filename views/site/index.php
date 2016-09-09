<?php

/* @var $this yii\web\View */
use yii\helpers\Url;

$this->title = 'My Yii Application';
?>

<div class="site-index">
    <div class="body-content">
        <div class="row">

            <h1>Начать работу</h1>

            <div class="col-md-6 col-md-offset-3">
                <div class="card card-block">
                    <?php if ($scripts) :?>
                        <?php foreach ($scripts as $item) :?>

                            <a href="<?php echo Url::toRoute(['/script/view', 'script' => $item->id]);?>" class="btn btn-default btn-block">
                                <?php echo $item->name;?>
                            </a>

                        <?php endforeach;?>
                    <?php endif;?>
                </div>
            </div>

        </div>
    </div>
</div>
