<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use yii\helpers\Html;

use app\widgets\Grid;

?>

<div class="site-index">
    <div class="body-content">
        <div class="row">

            <h1>Звонки</h1>

            <div class="col-md-8 col-md-offset-2">
                <div class="card card-block">
                    <?php echo grid::widget([
                        'show' => 'modalView',
                    ]);?>
                </div>
            </div>
        </div>
    </div>
</div>
