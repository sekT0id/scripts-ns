<?php

use yii\helpers\Url;
?>

<div id="item-<?php echo $item->id;?>" class="item-content item-modal">
    <a
       href="javascript: void(0);"
       data-set="<?php echo $item->id;?>"
    >
        <?php echo $item->name?>
    </a>
</div>
