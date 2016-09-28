<?php if ($client) :?>
    <div class="card card-block client-block">
        <div class="row">

            <div class="col-md-4">
                <p>
                    Звонок клиенту -
                    <b><?php echo $client->name;?></b>
                </p>
                <p>
                    <span class="glyphicon glyphicon-phone-alt" aria-hidden="true"></span>
                    <?php echo $client->phone;?>
                </p>
            </div>
            <div class="col-md-8">
                <p>
                    <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
                    <?php echo $client->data;?>
                </p>
            </div>

        </div>
    </div>
<?php endif;?>
