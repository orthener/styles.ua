<h1><?php echo __d('public', "SELF STATUS TEST", true); ?></h1>
<div>

    <form id="payformID" action="<?php echo Router::url(array(
        'plugin' => 'payments', 'controller' => 'payments', 'action' => 'status'
    )); ?>" enctype="multipart/form-data" method="post" name="payform">
        <?php foreach($params AS $key => $value){ ?>
            <input type="text" name="<?php echo $key; ?>" value="<?php echo $value; ?>" />
        <?php } ?>
        
        <input class="submit" type="submit" value="TEST" />
        
        
    </form>

        
</div>

