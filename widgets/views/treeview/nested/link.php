<?php

use yii\helpers\Url;
?>

<div class="item-content item-link">
    <?php echo $item->name?>


    <div class="btn-group pull-right">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="glyphicon glyphicon-chevron-down"></span>
        </button>
        <ul class="dropdown-menu">
            <li><a href="<?php echo Url::toRoute(['/script/delete', 'script' => $item->id]);?>">
                Удалить<span class="glyphicon glyphicon-pencil pull-right" aria-hidden="true"></span>
            </a></li>
        </ul>
    </div>
</div>
