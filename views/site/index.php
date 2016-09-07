<?php

/* @var $this yii\web\View */

use yii\helpers\Url;
use app\models\Script;
use app\widgets\TreeView;

$this->title = 'My Yii Application';

?>

<div class="site-index">
    <h1>Список скриптов</h1>

    <div class="body-content">

        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">

                <div class="form-group col-sm-6 text-left">
                    <a href="<?php echo Url::toRoute(['script/new']);?>" class="btn btn-success">Добавить</a>
                </div>
                <div class="form-group col-sm-6 text-right">
                    <button type="button" class="material btn btn-warning" id="btn-expand-all">Развернуть все</button>
                    <button type="button" class="btn btn-danger" id="btn-collapse-all">Свернуть все</button>
                </div>

            </div>
            <div class="col-sm-6 col-sm-offset-3">

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
        </div>

    </div>
</div>
