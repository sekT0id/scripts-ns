<?php

/* @var $this yii\web\View */

use yii\helpers\Url;
use app\extended\models\Script;

$this->title = 'My Yii Application';

$this->registerJsFile('/libs/bootstrap/js/bootstrap-treeview.min.js', [
    'depends' => 'yii\web\JqueryAsset',
    'position' => $this::POS_END,
]);

$this->registerJsFile('/js/extended-tree-view.js', [
    'depends' => 'yii\web\JqueryAsset',
    'position' => $this::POS_END,
]);

$jsCode = 'var treeData = '.Script::getJsonTreeView()."\n";
$this->registerJs($jsCode, $this::POS_BEGIN);
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
                    <button type="button" class="btn btn-warning" id="btn-expand-all">Развернуть все</button>
                    <button type="button" class="btn btn-danger" id="btn-collapse-all">Свернуть все</button>
                </div>

            </div>
            <div class="col-sm-6 col-sm-offset-3">
                <div id="tree"></div>
            </div>
        </div>

    </div>
</div>
