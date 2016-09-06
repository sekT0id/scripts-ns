<?php

use yii\helpers\Url;
?>

<a href="<?php echo Url::toRoute(['/script/view', 'script' => $item->id]);?>">
    <?php echo $item->name?>
</a>
<span class="badge">
    <a href="<?php echo Url::toRoute(['/script/edit', 'script' => $item->id]);?>">
        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
    </a>
</span>
