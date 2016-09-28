<?php if ($client) :?>
    <div class="card card-block client-block">
        <p>
            Звонок клиенту -
            <b><?php echo $client->name;?></b>
        </p>
        <p>
            <span class="glyphicon glyphicon-phone-alt" aria-hidden="true"></span>
            <?php echo $client->phone;?>
        </p>
        <p>
            <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
            <?php echo $client->data;?>
        </p>
    </div>
<?php endif;?>
