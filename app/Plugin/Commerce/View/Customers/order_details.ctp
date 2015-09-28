<?php $order = $actualOrder; ?>
<?php $title = __d('public', 'PODGLĄD ZAMÓWIENIA NUMER: '.$order['Order']['hash']); ?>
<?php $this->set('title_for_layout', $title); ?>
<?php echo $this->Html->css('ui-lightness/jquery-ui-1.8.14.custom',null, array('inline'=>false)) ?>
<?php echo $this->Html->script('jquery-ui-1.8.14.custom.min', array('inline'=>false)) ?>
<?php echo $this->Html->css('/commerce/css/commerce', null, array('inline' => false)) ?>
<?php echo $this->Html->css('print', null, array('inline' => false)) ?>
<?php echo $this->Html->css('configurator', null, array('inline' => false)) ?>
<div id="my-account" class="orders">
    <h1><?php echo $title ?></h1>
    <div>
        <?php echo $this->Html->link(__d('public', 'Powrót'), array('action' => 'order_item', $order['Order']['id'])); ?>
    </div>
    <div class="orders">
            <?php
            $key = 0;
            foreach ($order['OrderItem'] as $orderItem): ?>
                <?php echo $this->element($orderItem['product_plugin'].'.Commerce/OrderItemDetails', array('orderItem' => $orderItem, 'order' => $order)); ?>
            <?php endforeach; ?>
    </div>    
    
    <?php //debug($order); 
    ?>
<table cellpadding="0" cellspacing="0">
    <thead>
    <tr>
        <th><?php echo __d('public', 'Summe'); ?></th>
        <th><?php echo __d('public', 'Wartość netto'); ?></th>
        <th><?php echo __d('public', 'Wartość VAT'); ?></th>
        <th><?php echo __d('public', 'Wartość brutto'); ?></th>
    </tr>
    </thead>
    <tbody>
        <tr>
            <td></td>
            <td><?php echo $this->Number->currency($order['Order']['total']-$order['Order']['total_tax_value'], 'EUR'); ?></td>
            <td><?php echo $this->Number->currency($order['Order']['total_tax_value'], 'EUR'); ?></td>
            <td><?php echo $this->Number->currency($order['Order']['total'], 'EUR'); ?></td>
        </tr>
    </tbody>
</table>
    
    
</div>