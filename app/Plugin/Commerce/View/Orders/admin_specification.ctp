<?php $order ?>
<?php $title = __d('public', 'SPECYFIKACJA ZAMÓWIENIA NUMER: '.$order['Order']['hash']); ?>
<?php $this->set('title_for_layout', $title); ?>
<?php echo $this->Html->css('cms-print', null, array('inline' => false)) ?>
<?php echo $this->Html->css('configurator', null, array('inline' => false)) ?>
<?php echo $this->Html->css('configurator-specification', null, array('inline' => false)) ?>

<div id="my-account" class="orders">
    <h1><?php echo $title ?></h1>



    <div class="orders">
            <?php
            $key = 0;
            foreach ($order['OrderItem'] as $orderItem): ?>
                <?php echo $this->element($orderItem['product_plugin'].'.Commerce/OrderItemDetails', array('orderItem' => $orderItem, 'order' => $order)); ?>
            <?php endforeach; ?>
    </div>    
    
    <?php //debug($order); 
    ?>
    
    
</div>