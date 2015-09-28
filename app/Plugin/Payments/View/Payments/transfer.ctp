<?php $this->Session->flash(); ?>
<?php // echo date("Y-m-d H:i:s");           ?> 
<?php $this->Html->css('draw', null, array('inline' => false)); ?>
<?php $this->Html->addCrumb(__d('public', 'Strona główna'), '/'); ?>
<?php $this->Html->addCrumb(__d('public', 'Twój koszyk'), array('plugin' => 'commerce', 'controller' => 'orders', 'action' => 'cart')); ?>
<?php $this->Html->addCrumb(__d('public', 'Składanie zamówienia')); ?>
<div id="cart" class="clearfix orders">
    <div class="row-fluid">
        <div class="breadcrump span12 bt-no-margin">
            <span class="navi"><?php echo __d('front', 'NAVIGATION'); ?>:</span> <?php echo $this->Html->getCrumbList(array('class' => 'breadcrumb')); ?>
        </div>
    </div>
    <div class="white-background  clearfix">
        <div class="clearfix">
            <div class="cart-navi border-page row-fluid clearfix">
                <span>1. <?php echo __d('public', 'Twój koszyk');?></span> <i class="icon-arrow-right"></i> <span>2. <?php echo __d('front', 'Składanie zamówienia');?></span> <i class="icon-arrow-right"></i> <span class="active">3. <?php echo __d('public', 'Podsumowanie zakupu');?></span>
            </div>
            <div class="border-page padding20">
                <div class="transfer_line">
                    <div class="hgroup border-bottom">
                        <h2 style="display: inline-block;"><?php echo __d('public', 'Gratulujemy!'); ?></h2>
                        <br/>
                        <?php if ($order['Order']['payment_type'] == 0): //przelew ?>
                        <?php endif; ?>
                        <?php if ($order['Order']['payment_type'] == 1): //payU ?>
                        <?php endif; ?>
                        <?php if ($order['Order']['payment_type'] == 2): //pobranie | przy odbiorze ?>
                        <?php endif; ?>
                    </div>
                </div>
                <?php if ($order['Order']['payment_type'] == 0): //przelew ?>
                    <div id="transferDatas">
                        <h3><?php echo __d('public', 'Dane do przelewu:'); ?></h3>
                        <div class="transfer_line">
                            <?php
                            $page['Page']['desc'] = str_replace(array('::nr_zam::', '::suma::'), array($order['Order']['hash'], CakeNumber::currency($order['Order']['total'], ' ₴', array('wholePosition' => 'after'))), $page['Page']['desc']);
                            echo $page['Page']['desc'];
                            ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div id="none" class="dn">
    <p><b><?php echo __d('front', 'Szczegóły zamówienia');?>:</b></p>
    <div class="transfer_line">
        <div class="orders maxWidth">
            <table class="orders-table">
                <thead>
                    <tr>
                        <th><?php echo __d('front', 'Lp.');?></th>
                        <th></th>
                        <th><?php echo __d('front', 'Produkt');?></th>
                        <th><?php echo __d('front', 'Cena netto / szt.');?></th>                    
                        <th><?php echo __d('front', 'Ilość');?></th>
                        <th><?php echo __d('front', 'Suma brutto');?></th>
                    </tr>
                </thead>
                <?php
                $key = 0;
                foreach ($order['OrderItem'] as $key => $orderItem):
                    ?>
                    <?php $product_prices = Commerce::calculateByPriceType($orderItem['price'], $orderItem['tax_rate'], 1, $orderItem['discount']); ?>
                    <?php // echo $this->element($orderItem['product_plugin'].'.Commerce/OrderItemDetails', array('orderItem' => $orderItem, 'order' => $order));  ?>
                    <tr>
                        <td><?php echo $key + 1; ?></td>
                        <td>
                            <?php
                            $windowConfiguration = json_decode($orderItem['product'], true);

                            echo empty($windowConfiguration['WindowConfiguration']['id']) ? '' : $this->element('Window.WindowConfigurations/draw', array(
                                        'windowConfiguration' => $windowConfiguration,
                                        'objectID' => 'mainDraw' . $windowConfiguration['WindowConfiguration']['id'],
                                        'destWidth' => 135,
                                        'destHeight' => 100,
                            ));
                            echo empty($windowConfiguration['Photo']['id']) ? '' : $this->Image->thumb('/files/photo/' . $windowConfiguration['Photo']['img'], array('width' => '135', 'height' => 100));
                            ?>
                        </td>
                        <td  class="noMargin">
                            <?php echo empty($windowConfiguration['WindowConfiguration']['id']) ? '<h2>' . $orderItem['name'] . '</h2>' : $this->element('Window.Commerce/OrderItemFullDescription', compact('orderItem')); ?>

                        </td>
                        <?php // debug($orderItem);  ?>
                        <td class="alignCenter"><?php echo $this->Number->currency($product_prices['final_price_net'], 'PLN'); ?></td>                    
                        <td class="alignCenter"><?php echo $orderItem['quantity']; ?></td>
                        <td class="alignCenter"><?php echo $this->Number->currency($orderItem['quantity'] * $product_prices['final_price_gross'], 'PLN'); ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td><?php echo $key + 2; ?></td>
                    <td></td>
                    <td><b><?php echo $order['ShipmentMethod']['name']; ?></b></td>
                    <td class="alignCenter"><?php echo $this->Number->currency($order['Order']['shipment_price_net'], 'PLN'); ?></td>                
                    <td class="alignCenter"></td>
                    <td class="alignCenter"><?php echo $this->Number->currency($order['Order']['shipment_price_gross'], 'PLN'); ?></td>
                </tr>
                <?php if ($order['Order']['payment_type'] == 4): ?>
                    <tr>
                        <td><?php echo $key + 3; ?></td>
                        <td></td>
                        <td><b><?php echo __d('public', 'Prowizja od płatności częściowej') ?></b></td>
                        <td class="alignCenter"><?php echo $this->Number->currency($order['Order']['provision_total'], 'PLN'); ?></td>                
                        <td class="alignCenter"></td>
                        <td class="alignCenter"><?php echo $this->Number->currency($order['Order']['provision_total'] * 1.23, 'PLN'); ?></td>
                    </tr>
                <?php endif; ?>
                <tr class="summary">
                    <th colspan="2"></th>
                    <th style="text-align: right;"><?php echo __d('front', 'Razem');?>: </th>
                    <th><?php echo $this->Number->currency($order['Order']['total'] - $order['Order']['total_tax_value'], 'PLN'); ?></th>  
                    <th>
                    <th><?php echo $this->Number->currency($order['Order']['total'], 'PLN'); ?></th>                    
                </tr>
                <tbody>
            </table>
        </div>
    </div> 
</div>