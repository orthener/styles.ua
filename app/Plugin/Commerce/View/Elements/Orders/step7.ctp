<?php //debug($order);  ?>

<div class="orderPodsumowanie clearfix">
    <div class="clearfix send-address h4orderBottom">
        <div>
            <h4><?php echo __('Adres wysyłkowy:'); ?></h4>
            <p id="sendAddress"></p>
        </div>
    </div>
    <div class=" clearfix send-method h4orderBottom">
        <h4><?php echo __('Forma wysyłki:'); ?></h4>
        <p id="sendMethod"><?php echo $order['ShipmentMethod']['name']; ?></p>
    </div>
    <div class="clearfix payment-method h4orderBottom">
        <h4><?php echo __('Metoda płatności:'); ?></h4>
        <p id="paymentMethod"></p>
        <?php if (empty($order['PromotionCode']['value'])): ?>
            <?php if ($order['Customer']['discount'] > 0): ?>
                <h4><?php echo __('Kod osobisty aktywny'); ?></h4>
                <p><?php echo __('Zamówienie zawiera'); ?> <?php echo $order['Customer']['discount']; ?>% <?php echo __('rabatu');?></p>   
            <?php endif; ?>
        <?php else: ?>
            <?php if ($order['Customer']['discount'] > 0): ?>
                <?php if ($order['PromotionCode']['value'] >= $order['Customer']['discount']): ?>
                    <h4><?php echo __('Kod promocyjny aktywny!'); ?></h4>
                    <p><?php echo __('(większy niż kod osobisty)'); ?></p>
                    <p><?php echo __('Zamówienie zawiera'); ?> <?php echo $order['PromotionCode']['value']; ?>% <?php echo __('rabatu');?></p>
                <?php else: ?>
                    <h4><?php echo __('Kod osobisty aktywny!'); ?></h4>
                    <p><?php echo __('(większy niż kod promocyjny)'); ?></p>
                    <p><?php echo __('Zamówienie zawiera'); ?> <?php echo $order['Customer']['discount']; ?>% <?php echo __('rabatu');?></p>
                <?php endif; ?>
            <?php else: ?>
                <h4><?php echo __('Kod promocyjny aktywny!'); ?></h4>
                <p><?php echo __('Zamówienie zawiera'); ?> <?php echo $order['PromotionCode']['value']; ?>% <?php echo __('rabatu');?></p>                
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>