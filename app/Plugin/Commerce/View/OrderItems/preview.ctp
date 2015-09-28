<?php $product = json_decode($orderItem['OrderItem']['product'], true); ?>
<?php $product_prices = Commerce::calculateByPriceType($orderItem['OrderItem']['price'], $orderItem['OrderItem']['tax_rate'], 1, $orderItem['OrderItem']['discount']); ?>
<div>

    <?php echo $this->element($orderItem['OrderItem']['product_plugin'].'.Commerce/OrderItemFullDescription', array('orderItem' => $orderItem['OrderItem'])); ?>
    
</div>