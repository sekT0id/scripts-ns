

<div class="panel-heading" role="tab" id="heading-<?php echo $model->id;?>">
    <a
        role="button"
        data-toggle="collapse"
        data-parent="#accordion"
        href="#collapse<?php echo $model->id;?>"
        aria-expanded="true"
        aria-controls="collapse<?php echo $model->id;?>"
    >
       <div class="row">

            <div class="col-lg-3">
                <i class="glyphicon glyphicon-calendar"></i>
                <?php echo Yii::$app->formatter->asDate($model->timeStart);?>
            </div>

            <div class="col-lg-3">
                <i class="glyphicon glyphicon-phone-alt"></i>
                <?php echo $model->client->phone;?>
            </div>

            <div class="col-lg-3">
                <i class="glyphicon glyphicon-user"></i>
                <?php echo $model->client->name;?>
            </div>
            <div class="col-lg-3">
                <?php if ($model->comment) :?>
                    <i class="glyphicon glyphicon-comment"></i>
                    <?php echo $model->comment;?>
                <?php endif;?>
           </div>

        </div>
    </a>
</div>

<div
   id="collapse<?php echo $model->id;?>"
   class="panel-collapse collapse"
   role="tabpanel"
   aria-labelledby="heading<?php echo $model->id;?>"
>
    <div class="panel-body row">
        <?php foreach ($model->details as $detail) :?>
            <div class="col-sm-2">
                <i class="glyphicon glyphicon-time"></i>
                <?php echo Yii::$app->formatter->asTime($detail->timeStart, 'HH:mm:ss');?>
            </div>
            <div class="col-sm-10">
                <i class="glyphicon glyphicon-play"></i>
                <?php echo $detail->script->name;?><br>
            </div>
        <?php endforeach;?>

    </div>
</div>

