<?php

/* @var $this yii\web\View */

use yii\helpers\Url;
use app\models\Script;
use app\widgets\TreeView;

$this->registerJsFile('/libs/nice-tree/src/easyTree.js', [
    'depends' => 'yii\web\JqueryAsset',
    'position' => $this::POS_END,
]);

$this->registerJsFile('/js/extended-easy-tree.js', [
    'depends' => 'yii\web\JqueryAsset',
    'position' => $this::POS_END,
]);

$this->title = 'My Yii Application';

?>

<div class="site-index">
    <div class="body-content">
        <div class="row">

            <h1>Список скриптов</h1>

            <div class="col-md-6 col-md-offset-3">

                <?php echo TreeView::widget([
                    'indentContent' => '<span class="glyphicon glyphicon-option-vertical"></span>',
                    'nodeOptions' => [
                        'class' => 'list-group',
                    ],
                    'itemOptions' => [
                        'class' => 'list-group-item node-tree',
                    ],
                ]);?>

            </div>

            <div class="col-md-2">
                <div class="card card-block text-center">
                    <a href="<?php echo Url::toRoute(['script/new']);?>" class="btn btn-fixed btn-success">
                        Добавить
                    </a>
                </div>
            </div>

        </div>

       <div class="col-md-6 col-md-offset-3">
            <?php echo TreeView::widget([
                'treeType' => 'nestedTree',
                'treeOptions' => [
                    'class' => 'easy-tree card card-block',
                ],
                'indentContent' => '<span class="glyphicon glyphicon-option-vertical"></span>',
            ]);?>
        </div>

    </div>
</div>
