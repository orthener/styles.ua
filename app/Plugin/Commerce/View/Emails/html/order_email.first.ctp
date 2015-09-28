<?php $paymentTotal = 0; ?>

<p><?php __d('public', "Witaj!"); ?></p>
<p><?php echo "Dziękujemy za złożenie zamówienia. Twoje zamówienie zostało
zarejestrowane pod numerem {$order['Order']['hash']}."; ?></p>

<?php if($order['Order']['payment_type'] == 2){ ?>
    <p>&nbsp;</p>
    <p>Zamówienie zostało zapisane - dokonaj wpłaty. <br /><br />Dane do przelewu: <br />
        <b><?php echo Configure::read('Commerce.company_name'); ?></b><br />
        <?php echo Configure::read('Commerce.company_address'); ?><br />
        <?php echo Configure::read('Commerce.company_post_code');?> <?php echo Configure::read('Commerce.company_city'); ?>
    </p>
    <p>Twoje zamówienie zostało zapisane w naszym systemie. Aby zostało zrealizowane należy dokonać płatności.</p>
    <p>
        <b>Do zapłaty:</b> <?php echo ($order['Order']['total'] - $paymentTotal) > 0 ? ($order['Order']['total'] - $paymentTotal) : 0; ?> zł
    </p>
    <p>
        NUMER KONTA BANKOWEGO: <br />
        <?php echo  Configure::read('Commerce.company_bank_account'); ?>
    </p>
    <p>&nbsp;</p>
<p><?php echo "Po otrzymaniu wpłaty Twoje zamówienie zostanie przekazane do realizacji. Jeżeli w ciągu 14 dni nie otrzymamy wpłaty, zamówienie zostanie anulowane."; ?></p>
<?php } ?>
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
        <b>Dostawa</b>: <?php echo $shipmentMethods[$order['Order']['shipment_method_id']]; ?> - <?php echo $order['Order']['shipment_price'] ?>zł <br /> 
        <b>Szczegóły zamówienia:</b><br />
        <ul>
        <?php foreach ($order['OrderItem'] as $product): ?>
            <?php $pTempQuatity = Commerce::calculateByPriceType($product['price'], $product['tax_rate'], $product['quantity'], $product['discount'])?>
            <?php $pTemp = Commerce::calculateByPriceType($product['price'], $product['tax_rate'], 1, $product['discount'])?>
           <li><?php echo $product['name'] ?> <?php echo $febNumber->priceFormat($pTemp['final_price_gross']); ?> x <?php echo $product['quantity'] ?> = <?php echo $febNumber->priceFormat($pTempQuatity['final_price_gross']); ?>
                <?php if (!empty($product['desc'])) { ?>
                    <br />
                    <i>(<?php echo $product['desc']; ?>)</i>
                 <?php } ?>
                <?php if (!empty($product['OrderItemFile'])) {
                    foreach($product['OrderItemFile'] as $k => $orderItemFile) {
                       if ($orderItemFile['accepted'] == 2) {
                           //Projekt Zakceptowany ?>
                            <br />
                            <span style='color: red'><b><?php echo $orderItemFile['name']; ?></b> - Brak Akceptacji!</span>
                            <br />
                            <?php if (!empty($orderItemFile['desc'])) { ?>
                            <i>(<?php echo $orderItemFile['desc']; ?></i>)
                            <?php } ?>
                       <?php } elseif ($orderItemFile['accepted'] == 1) {
                           //Projekt ?>
                           <br />
                           <span style='color: green'><b><?php echo $orderItemFile['name']; ?></b> - Status Zaakceptowany</span>
                           <?php 
                       } elseif ($orderItemFile['accepted'] == 0) {
                           //W trakcie akceptacji
                       }
                    }
                   
               } ?>
           </li>
        <?php endforeach ?>
        </ul>    
           
        <b>RAZEM</b> (z kosztami wysyłki): <?php echo $order['Order']['total'] ?>zł<br />
        <b>Zapłacono:</b> <?php echo $paymentTotal ?>zł<br />
        <b>Pozostało:</b> <?php echo ($order['Order']['total'] - $paymentTotal) > 0 ? ($order['Order']['total'] - $paymentTotal) : 'Nadplata ' . ($order['Order']['total'] - $paymentTotal); ?>zł<br />
        =====================<br />