<?php

use yii\helpers\Url;
?>
<div class="item-name">
    <a href="<?php echo Url::toRoute(['/script/view', 'script' => $item->id]);?>">
        <?php echo $item->name?>
    </a>
</div>

<div class="item-controls">
    <div class="btn-group pull-right">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="glyphicon glyphicon-chevron-down"></span>
        </button>
        <ul class="dropdown-menu">
            <li><a href="<?php echo Url::toRoute(['/script/edit', 'script' => $item->id]);?>">
                Редактировать<span class="glyphicon glyphicon-pencil pull-right" aria-hidden="true"></span>
            </a></li>
            <li><a href="<?php echo Url::toRoute(['/script/new', 'script' => $item->id]);?>">
                Добавить вложенный<span class="glyphicon glyphicon-plus pull-right" aria-hidden="true"></span>
            </a></li>
        </ul>
    </div>
</div>
