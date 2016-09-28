<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use yii\helpers\Html;

use app\widgets\Grid;

?>

<div class="site-index">
    <div class="body-content">
        <div class="row">

            <h1>Клиенты</h1>

            <div class="col-md-8 col-md-offset-2">
                <div class="card card-block">
                    <a href="<?php echo Url::toRoute(['client/new']);?>" class="btn btn-default btn-block">
                        Добавить
                    </a>
                </div>
            </div>

            <div class="col-md-8 col-md-offset-2">
                <div class="card card-block">

                    <?php echo Grid::widget([
                        'show' => 'fullView',
                    ]);?>

                </div>
            </div>

        </div>
    </div>
</div>
