

<div class="panel-heading" role="tab" id="heading-<?php echo $model->id;?>">
    <a
        role="button"
        data-toggle="collapse"
        data-parent="#accordion"
        href="#collapse<?php echo $model->id;?>"
        aria-expanded="true"
        aria-controls="collapse<?php echo $model->id;?>"
    >
        <?php echo $model->timeStart;?> -
        <?php echo $model->client->name;?> -
        <?php echo $model->client->phone;?>
    </a>
</div>

<div
   id="collapse<?php echo $model->id;?>"
   class="panel-collapse collapse"
   role="tabpanel"
   aria-labelledby="headingOne"
>
    <div class="panel-body">
        <?php foreach ($model->details as $detail) :?>

            <?php echo $detail->timeStart;?> -
            <?php echo $detail->script->name;?><br>
        <?php endforeach;?>
    </div>
</div>

