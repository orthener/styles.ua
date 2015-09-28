<div class="orderPaySelect">
    <div class="radio input">
        <?php echo $this->Form->radio('Order.payment_type', $paymentTypes, array('legend' => false, 'class' => 'updatePrices', 'separator' => '</div><div class="radio input">')); ?>
    </div>
</div>
<?php 
//debug($order);
//debug($paymentTypes); 
?>
