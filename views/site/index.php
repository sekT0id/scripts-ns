<?php

/* @var $this yii\web\View */

use yii\helpers\Url;
use app\models\Script;
use app\widgets\TreeView;

$this->title = 'My Yii Application';

?>

<div class="site-index">
    <div class="body-content">
        <div class="row">

            <h1>Список скриптов</h1>

            <div class="col-md-6 col-md-offset-3">

                <?php echo TreeView::widget([
                    'treeType' => 'simpleList',
                    'nodeOptions' => [
                        'class' => 'list-group',
                    ],
                    'itemOptions' => [
                        'class' => 'list-group-item node-tree',
                    ]
                ]);?>

            </div>

            <div class="col-md-2">
                <div class="card card-block text-center">
                    <a href="<?php echo Url::toRoute(['script/new']);?>" class="btn btn-fixed btn-success">Добавить</a>
                </div>
                <div class="card card-block text-center">
                    <button type="button" class="btn btn-fixed btn-warning" id="btn-expand-all">Развернуть все</button>
                    <button type="button" class="btn btn-fixed btn-danger" id="btn-collapse-all">Свернуть все</button>
                </div>
            </div>

        </div>

    </div>
</div>
