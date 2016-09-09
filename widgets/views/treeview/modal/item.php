<?php

use yii\helpers\Url;
?>

<div id="item-<?php echo $item->id;?>" class="item-content item-modal">
    <a
       href="javascript: void(0);"
       onclick="
            $('.item-modal').removeClass('btn-default');
            $('#item-<?php echo $item->id;?>').toggleClass('btn-default');
            $('#form-id').val(<?php echo $item->id;?>);
            $('#link-submit').removeAttr('disabled');
            ">

        <?php echo $item->name?>
    </a>
</div>
