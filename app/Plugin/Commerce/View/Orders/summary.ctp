<?php
//echo $this->FebHtml->meta('description','',array('inline'=>false));
//echo $this->FebHtml->meta('keywords','',array('inline'=>false));
$this->set('title_for_layout', __d('public', 'Podsumowanie'));
?>
<?php echo $this->Html->css('ui-lightness/jquery-ui-1.8.14.custom', null, array('inline' => false)) ?>
<?php echo $this->Html->script('jquery-ui-1.8.14.custom.min', array('inline' => false)) ?>
<?php echo $this->Html->css('/commerce/css/commerce', null, array('inline' => false)) ?>
<?php echo $this->Html->css('configurator', null, array('inline' => false)) ?>
<div class="orders view clearfix">

    <h1 class="orange"><?php echo __d('public', 'PODSUMOWANIE'); ?></h1>

    <?php echo $this->element('Orders/steps', array('plugin' => 'commerce', 'step' => 3)); ?>

    <?php if (!empty($order['OrderItem'])): ?>
        <table cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th><?php echo __d('public', 'Nazwa produktu'); ?></th>
                    <th><?php echo __d('public', 'Cena brutto'); ?></th>
                    <th><?php echo __d('public', 'Ilosć'); ?></th>
                    <th><?php echo __d('public', 'Wartość<br /> brutto'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php $tmp = Commerce::getTotalPricesForOrder($order); ?>
                <?php
                $i = 0;
    
                foreach ($order['OrderItem'] as $orderItem):
                    $class = null;
                    if ($i++ % 2 == 0) {
                        $class = 'class="altrow"';
                    }
                    ?>
                    <tr <?php echo $class; ?>  <?php echo 'id="' . 'quantity' . $orderItem['id'] . '"' ?>>
                        <?php echo $this->element('Orders/order_product', array('plugin' => 'commerce', 'orderItem' => $orderItem, 'total' => $tmp['final_price_gross'])); ?>
                    </tr>
                <?php endforeach; ?>    
            </tbody>    
        </table>
        <div class="widthCenter">       
            <div class="summaryText clearfix" >
                <?php echo __d('public', 'Razem:'); ?>  
                <b>
                    <span id="razem-bez-wysylki"><?php //echo str_replace(array(',00', '.'), array('', ','), $tmp['final_price_gross']);     ?>
                        <?php echo $this->Number->currency($tmp['final_price_gross'], 'EUR'); ?>
                    </span>
                    <?php echo __d('public', '(brutto)'); ?>
                </b>
            </div>
        <?php endif; ?>

        <?php //unset($order['OrderItem']); debug($order);  ?>

        <?php
        //debug($order);
        ?>

        <h1 class="clearfix blue">
            <div class="halfBox">
                <?php echo __d('public', 'Forma płatności'); ?>
            </div>
            <div class="halfBox">
                <?php echo __d('public', 'Sposób wysyłki'); ?>
            </div>
        </h1>

        <div class="clearfix">
            <div class="halfBox">
                <div class="paymentTypeInfo">
                    <?php echo $paymentTypes[$order['Order']['payment_type']]; ?>
                </div>
            </div>
            <div class="halfBox">
                <div class="shipmentMethodInfo">
                    <?php $pTmp = Commerce::calculateByPriceType($order['Order']['shipment_price'], $order['Order']['shipment_tax_rate'], 1, $order['Order']['shipment_discount']) ?>
                    <?php echo empty($order['ShipmentMethod']['img']) ? '' : $this->Html->image('/files/shipmentmethod/' . $order['ShipmentMethod']['img']); ?>
                    <?php echo $order['ShipmentMethod']['name']; //. ' ' . str_replace(array(',00', '.'), array('', ','), ()) . ' ₴'; ?> 
                    <?php echo $this->Number->currency($pTmp['final_price_gross'], 'EUR'); ?>
                </div>

            </div>
        </div>
        <div class="clearfix" id="invoiceIdentity">

            <div class="halfBox">
                <div class="p10">
                    <?php //debug($order);  ?>
                    <b>Dane do faktury:</b><br />
                    <?php //echo $order['Customer']['contact_person'] ?><br />
                    <?php echo $order['Order']['invoice_identity']['name'] ?><br />
                    <?php echo ($order['Order']['invoice_identity']['iscompany']) ? 'NIP: ' . $order['Order']['invoice_identity']['nip'] . '<br />' : ''; ?>
                    <?php echo $order['Order']['invoice_identity']['address']; ?><br />
                    <?php echo $order['Order']['invoice_identity']['post_code'] ?> <?php echo $order['Order']['invoice_identity']['city'] ?><br />

                </div>
            </div>
            <div class="halfBox">
                <div class="p10">
                    <b>Dane do wysyłki:</b><br />
                    <?php //echo $order['Customer']['contact_person'] ?><br />
                    <?php echo $order['Order']['address']['name'] ?><br />
                    <?php echo $order['Order']['address']['address'] ?><br />
                    <?php echo $order['Order']['address']['post_code'] ?> <?php echo $order['Order']['address']['city'] ?><br />
                    <?php echo $order['Customer']['phone'] ? 'tel.' . $order['Customer']['phone'] : ''; ?><br />

                </div>
            </div>
        </div>

        <div class="summaryText clearfix">
            <?php echo __d('public', 'Do zapłaty:'); ?>  
            <b>
                <?php //debug($order); ?>
                <?php $tmp = Commerce::getTotalPricesForOrder($order); ?>
                <span id="razem-z-wysylka"><?php //echo str_replace(array('.00', '.'), array('', ','), ($tmp['final_price_gross']))     ?>
                    <?php echo $this->Number->currency($tmp['final_price_gross'], 'EUR'); ?>
                </span> 
                <?php echo __d('public', '(brutto)'); ?>
            </b>
        </div>
    </div>


    <?php echo $this->Form->create('Order'); ?>

    <?php echo $this->Form->hidden('ok'); ?>
    <fieldset class="clearfix">
        <?php echo $this->Html->link('Wstecz', array('controller' => 'customers', 'action' => 'add'), array('class' => 'blueButton fl')); ?>
        <?php echo $this->Form->submit('Zamawiam', array('class' => 'orangeButton fr', 'div' => false)); ?>
    </fieldset>

    <?php echo $this->Form->end(); ?>

</div>