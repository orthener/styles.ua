<?php $paymentTotal = 0; ?>

<p><?php __d('public', "Witaj!"); ?></p>
<p>&nbsp;</p>
<p><?php echo "W serwisie " . $this->Html->link('Street Style Shop', $this->Html->url('/', true)) . " zarejestrowano nowe zamówienie, pod nr {$order['Order']['hash']}."; ?></p>
<p><?php echo "Będziemy informować o każdej zmianie statusu zamówienia przez email."; ?></p>
<br />
=====================<br />

<b>Status:</b> <?php echo isset($order['OrderStatus']['name']) ? $order['OrderStatus']['name'] : 'Nie znany' ?><br />

<?php if (!empty($order['Payment'])) { ?>
    <b>Płatności:</b><br />
    <ul>
        <?php foreach ($order['Payment'] as $k => $payment) { ?>
            <li><?php echo $payment['payment_gate']; ?> - <?php echo $payment['amount']; ?> - <?php echo $statuses[$payment['status']]; ?> <?php echo $payment['payment_date']; ?> </li>
        <?php } ?>
    </ul>
<?php } ?>
    <?php 
    $bonusFactor = 0;
    if(!empty($order['PromotionCode']['value'])) {
        if(!empty($order['Customer']['discount'])) {
            $bonusFactor = $order['PromotionCode']['value'] >= $order['Customer']['discount'] ? $order['PromotionCode']['value'] : $order['Customer']['discount'];
        } else {
            $bonusFactor = $order['PromotionCode']['value'];
        }
    } else {
        $bonusFactor = empty($order['Customer']['discount']) ? 0 : $order['Customer']['discount'];
    }
    $shipmentPriceGross = $order['Order']['shipment_price_gross'];
    //$shipmentPriceBonus = $shipmentPriceGross - $shipmentPriceGross * ($bonusFactor/100);
    
    // echo number_format($order['Order']['shipment_price_gross'], 2, ',', '');
    
    ?>      
    
    
<b>Dostawa</b>: <?php echo $shipmentMethods[$order['Order']['shipment_method_id']]; ?> - <?php echo number_format($shipmentPriceGross, 2, ',', ''); ?> ₴<br /> 
<b>Szczegóły zamówienia:</b><br />
<ul>
    <?php foreach ($order['OrderItem'] as $orderItem): ?>
        <?php
        $discount = 0;
        if (empty($order['PromotionCode']['value'])) {
            if ($order['Customer']['discount'] > 0) {
                $discount = $order['Customer']['discount'];
            }
        } else {
            if ($order['Customer']['discount'] > 0) {
                if ($order['PromotionCode']['value'] >= $order['Customer']['discount']) {
                    $discount = $order['PromotionCode']['value'];
                } else {
                    $discount = $order['Customer']['discount'];
                }
            } else {
                $discount = $order['PromotionCode']['value'];
            }
        }
        $product_prices = Commerce::calculateByPriceType($orderItem['price'], $orderItem['tax_rate'], 1, $discount);
        ?>
        <li><?php echo $orderItem['name'] ?> <?php echo number_format($product_prices['final_price_gross'], 2, ',', '') ?> ₴ x <?php echo $orderItem['quantity'] ?> = <?php echo number_format($product_prices['final_price_gross'] * $orderItem['quantity'], 2, ',', '') ?> ₴</li>
    <?php endforeach ?>
</ul>    

<b>RAZEM</b> (z kosztami wysyłki): <?php echo number_format($order['Order']['total'], 2, ',', ''); ?> ₴<br />
<b>Zapłacono:</b> <?php echo number_format($paymentTotal, 2, ',', ''); ?> ₴<br />
<b>Pozostało:</b> <?php echo ($order['Order']['total'] - $paymentTotal) > 0 ? ($order['Order']['total'] - $paymentTotal) : 'Nadplata ' . ($order['Order']['total'] - $paymentTotal); ?> ₴<br />
=====================<br />

<?php if ($order['Order']['payment_type'] == 0): //przelew ?>
    <div id="transferDatas">
        <h2><?php echo __d('public', 'Dane do przelewu:'); ?></h2>
        <div class="transfer_line">
            <?php
            $page['Page']['desc'] = str_replace(array('::nr_zam::', '::suma::'), array($order['Order']['hash'], CakeNumber::currency($order['Order']['total'], ' ₴', array('wholePosition' => 'after'))), $page['Page']['desc']);
            echo $page['Page']['desc'];
            ?>
        </div>
    </div>
<?php endif; ?>