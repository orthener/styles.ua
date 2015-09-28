<?php $order; ?>
<?php $title = __d('public', 'PODGLĄD ZAMÓWIENIA NUMER: ') . ' '. $order['Order']['hash']; ?>
<?php $this->set('title_for_layout', $title); ?>
<?php // echo $this->Html->css('cms-print', null, array('media' => 'print', 'inline' => false)) ?>
<?php echo $this->Html->css('configurator', null, array('inline' => false)) ?>
<?php echo $this->Html->css('draw', null, array('inline' => false)) ?>
<div id="headerPrint">
    <?php // echo $this->Html->image('layouts/default/logo_print.png', array('class' => 'fl')); ?>
    <big>
        <!--Angebot/ Bestellung/ Auftragsbestätigung: <br />-->
        <?php echo $order['Order']['hash']; ?> <br />
        <?php echo __d('cms', 'Data'); ?>: <?php echo date('d.m.Y', strtotime($order['Order']['created'])); ?>
    </big> <br />

    <!--Das Angebot ist 10 Tage gültig!-->

</div>

<div id="my-account" class="orders">
    <h1><?php echo $title ?></h1>


    <b><?php echo __d('cms', 'Data utworzenia zamówienia'); ?>:</b> <?php echo $this->FebTime->niceShort($order['Order']['created']); ?><br/>
    <b><?php echo __d('cms', 'Ostatnia modyfikacja'); ?>:</b> <?php echo $this->FebTime->niceShort($order['Order']['modified']); ?><br/><br/>

    <table id="order-table" class="noBorder">
        <tr>
            <td>
                <fieldset id="customer-contact">
                    <legend><?php echo __d('cms', 'Dane Klienta'); ?></legend>
                    <?php echo $order['Customer']['contact_person']; ?><br />
                    <?php echo $order['Customer']['email']; ?><br />
                    <?php echo $order['Customer']['phone']; ?><br />

                </fieldset>
            </td>
            <td>
                <fieldset>
                    <legend><?php echo __d('cms', 'Status'); ?></legend>

                    <?php echo $orderStatuses[$order['Order']['order_status_id']]; ?>  <br />
                    <?php echo $order['Order']['track_number']; ?>  <br />
                    <?php echo $order['Order']['vat']; ?>  <br />
                </fieldset>
            </td>
        </tr>
        <tr>
            <td>
                <fieldset id="shipment-metod">
                    <legend><?php echo __d('cms', 'Dane do Wysyłki'); ?></legend>
                    <?php echo $order['Order']['address']['name']; ?>  <br />
                    <?php echo $order['Order']['address']['address']; ?> <?php echo $order['Order']['address']['nr']; ?><?php echo !empty($order['Order']['address']['flat_nr']) ? '/'.$order['Order']['address']['flat_nr'] : ''; ?>  <br />
                    <?php echo $order['Order']['address']['post_code']; ?> <?php echo $order['Order']['address']['city']; ?>  <br />
                    <?php echo $order['Order']['address']['country_id']; ?>      <br />
                </fieldset>
            </td>
            <td rowspan="1">
                <fieldset id="invoice-identities">
                    <legend><?php echo __d('cms', 'Dane do Faktury'); ?></legend>
                    <?php echo $order['Order']['invoice_identity']['name']; ?><br />
                    <?php echo $order['Order']['invoice_identity']['address']; ?> <?php echo !empty($order['Order']['invoice_identity']['nr']) ? $order['Order']['invoice_identity']['nr'] : ''; ?><?php echo !empty($order['Order']['invoice_identity']['flat_nr']) ? '/'.$order['Order']['invoice_identity']['flat_nr'] : ''; ?>  <br />
                    <?php echo $order['Order']['invoice_identity']['post_code']; ?> <?php echo $order['Order']['invoice_identity']['city']; ?><br />
                    <?php echo $order['Order']['invoice_identity']['country_id']; ?><br />
                    <?php if ($order['Order']['invoice_identity']['iscompany'] == 1) { ?>
                        <?php echo __d('commerce', 'NIP: ') . $order['Order']['invoice_identity']['nip']; ?><br />
                    <?php } ?>

                </fieldset>
            </td>
        </tr>
    </table>


    <div class="orders">
        <table class="orders-table">
            <thead>
                <tr>
                    <th><?php echo __d('public', ''); ?>.</th>
                    <th></th>
                    <th><?php echo __d('public', 'Produkt'); ?>:</th>
                    <th><?php echo __d('public', 'Ilość'); ?>:</th>
                    <th><?php echo __d('public', 'Wartość netto'); ?>:</th>
                    <th><?php echo __d('public', 'Wartość brutto'); ?>:</th>
                </tr>
            </thead>
            <?php
            $key = 0;
            foreach ($order['OrderItem'] as $key => $orderItem):
                ?>
                <?php // echo $this->element($orderItem['product_plugin'].'.Commerce/OrderItemDetails', array('orderItem' => $orderItem, 'order' => $order));  ?>
                <tr>
                    <td><?php echo $key + 1; ?></td>
                    <td>
                        <?php
                        $windowConfiguration = json_decode($orderItem['product'], true);

                        echo empty($windowConfiguration['WindowConfiguration']['id']) ? '':$this->element('Window.WindowConfigurations/draw', array(
                                    'windowConfiguration' => $windowConfiguration,
                                    'objectID' => 'mainDraw' . $windowConfiguration['WindowConfiguration']['id'],
                                    'destWidth' => 135,
                                    'destHeight' => 100,
                                )) ;
                        echo empty($windowConfiguration['Photo']['id'])?'':$this->Image->thumb('/files/photo/'.$windowConfiguration['Photo']['img'], array('width'=>'135','height'=>100));
                        ?>
                    </td>
                    <td  class="noMargin">
                        <?php echo empty($windowConfiguration['WindowConfiguration']['id']) ? '<h2>'.$orderItem['name'].'</h2>' : $this->element('Window.Commerce/OrderItemFullDescription', compact('orderItem')); ?>
                            <?php if (!empty($orderItem['size'])): ?>
                            <br/>
                            <small><?php echo __d('cms', 'rozmiar'); ?> <?php echo $orderItem['size'];?></small>
                        <?php endif; ?>
                    </td>
                        <?php // debug($orderItem);  ?>
                    <td><?php echo $orderItem['quantity']; ?></td>
                    <td><?php echo $this->Number->currency($orderItem['price'], 'PLN'); ?></td>
                    <td><?php echo $this->Number->currency($orderItem['quantity'] * $orderItem['price_gross'], 'PLN'); ?></td>
                </tr>
            <?php endforeach; ?>
                <tr>
                    <td><?php echo $key + 2;  ?></td>
                    <td></td>
                    <td><b><?php echo __d('public', 'Sposób dostawy'); ?>:</b> <?php echo $order['ShipmentMethod']['name'];  ?></td>
                    <td></td>
                    <td><?php echo $this->Number->currency($order['Order']['shipment_price_net'], 'PLN');  ?></td>
                    <td><?php echo $this->Number->currency($order['Order']['shipment_price_gross'], 'PLN');  ?></td>
                </tr>
                <tr>
                    <th colspan="2"></th>
                    <th colspan="3"><?php echo __d('public', 'Suma'); ?></th>
                    <th><?php echo $this->Number->currency($order['Order']['total'], 'PLN');  ?></th>                    
                </tr>
            <tbody>

        </table>
    </div>    

    <?php //debug($order); 
    ?>
<!--    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?php // echo __d('public', 'Summe');         ?></th>
                <th><?php // echo __d('public', 'Wartość netto');         ?></th>
                <th><?php // echo __d('public', 'Wartość VAT');         ?></th>
                <th><?php // echo __d('public', 'Wartość brutto');         ?></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td></td>
                <td><?php // echo $this->Number->currency($order['Order']['total'] - $order['Order']['total_tax_value'], 'EUR');         ?></td>
                <td><?php // echo $this->Number->currency($order['Order']['total_tax_value'], 'EUR');         ?></td>
                <td><?php // echo $this->Number->currency($order['Order']['total'], 'EUR');         ?></td>
            </tr>
        </tbody>
    </table>-->


</div>
<!--<div id="footerPrint">
    <div class="fr">
        Bankverbindung: <br />
        Postbank BLZ: 500 100 60 <br />
        Kto. Nr. 562 560 609 <br />
        PayPal: paypal@top-fenster.eu
    </div>
    <div class="fl">
        top-fenster.eu GbR <br />
        Kampweg 40 <br />
        41751 Viersen
    </div>
    <div>
        Tel: 02162 8908344 <br />
        Fax: 02162 8902423 <br />
        E-mail: info@top-fenster.eu
    </div>
</div>-->