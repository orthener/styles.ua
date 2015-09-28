<?php
//echo $this->FebHtml->meta('description','',array('inline'=>false));
//echo $this->FebHtml->meta('keywords','',array('inline'=>false));
//http://okna/commerce/customers/order_item/11
?>
<?php echo $this->Html->css('/commerce/css/commerce', null, array('inline' => false)) ?>
<?php echo $this->Html->css('configurator', null, array('inline' => false)) ?>
<div class="white orders">
    <h1 class="orange"><?php echo $title_for_layout; ?></h1>
        <?php echo $content_for_view; ?>

        <?php if (!empty($order)) { ?>
            <div class="clearfix">
                <h2>Podsumowanie zamówienia nr <big><?php echo $order['Order']['hash']; ?></big></h2>
                <div class="clearfix">
                        <table cellpadding="0" cellspacing="0">
                            <thead>
                            <tr>
                                <th>&nbsp;</th>
                                <th><?php echo __d('public', 'Nazwa produktu'); ?></th>
                                <th><?php echo __d('public', 'Cena brutto'); ?></th>
                                <th><?php echo __d('public', 'Ilość brutto'); ?></th>
                                <th><?php echo __d('public', 'Wartość brutto'); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $key = 0;
                            foreach ($order['OrderItem'] as $orderItem):
                                $class = ($key % 2 == 0) ? ' class="altrow"' : '';
                                ++$key;
                                ?>
                                <tr <?php echo $class; ?>  <?php echo 'id="' . 'quantity' . $orderItem['id'] . '"' ?>>
                                    <?php $product = json_decode($orderItem['product'], true); ?>
                                    <?php $product_prices = Commerce::calculateByPriceType($orderItem['price'], $orderItem['tax_rate'], 1, $orderItem['discount']); ?>

                                    <td class="photo">
                                    <?php 
                                    
                                    echo!empty($product['Photo']['img']) ? $this->Image->thumb('/files/photo/'.$product['Photo']['img'], array('width' => '135', 'height' => '100','frame'=>'#fff')) : '&nbsp;'; 
                        echo !empty($product['WindowConfiguration']['id'])?$this->element('Window.WindowConfigurations/draw', array(
                            'windowConfiguration' => $product, 
                            'objectID' => 'mainDraw'.$product['WindowConfiguration']['id'],
                            'destWidth' => 129,
                            'destHeight' => 100,
                            )):'';
                        echo !empty($product['FabricStyle']['id'])?$this->Image->thumb('/files/fabricstyle/'.$product['FabricStyle']['img'], array('width' => '135', 'height' => '100','frame'=>'#fff')) :'';
                                    
                                    ?>
                                    </td>
                                    <td>
                                        <h2><?php echo $orderItem['name']; ?></h2>
                                        <span class="desc"><?php echo $orderItem['desc']; ?></span>
                                    </td>
                                    <td>
                                        <?php echo ($product_prices['price_gross'] != $product_prices['final_price_gross']) ? '<span class="through">' . $this->FebNumber->priceFormat($product_prices['price_gross']) . '</span><br />' : ''; ?>
                                        <?php echo $this->Number->currency($product_prices['final_price_gross'], 'EUR'); ?>
                                    </td>
                                    <td><?php echo $orderItem['quantity']; ?></td>
                                    <td>
                                        <?php echo ($product_prices['price_gross'] != $product_prices['final_price_gross']) ? '<span class="through">' . $this->FebNumber->priceFormat($product_prices['price_gross']*$orderItem['quantity']) . '</span><br />' : ''; ?>
                                        <?php echo $this->Number->currency($product_prices['final_price_gross']*$orderItem['quantity'], 'EUR'); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                                       

                    <div class="widthCenter clearfix">
                        <div class="halfBox">
                            <div class="p10">
                                <?php //debug($order);   ?>
                                <b>Dane do faktury:</b><br />
                                <?php //echo $order['Customer']['contact_person']  ?><br />
                                <?php echo $order['Order']['invoice_identity']['name'] ?><br />
                                <?php echo ($order['Order']['invoice_identity']['iscompany']) ? 'NIP: ' . $order['Order']['invoice_identity']['nip'] . '<br />' : ''; ?>
                                <?php echo $order['Order']['invoice_identity']['address']; ?><br />
                                <?php echo $order['Order']['invoice_identity']['post_code'] ?> <?php echo $order['Order']['invoice_identity']['city'] ?><br />
    
                            </div>
                        </div>
                        <div class="halfBox">
                            <div class="p10">
                                <b>Dane do wysyłki:</b><br />
                                <?php //echo $order['Customer']['contact_person']  ?><br />
                                <?php echo $order['Order']['address']['name'] ?><br />
                                <?php echo $order['Order']['address']['address'] ?><br />
                                <?php echo $order['Order']['address']['post_code'] ?> <?php echo $order['Order']['address']['city'] ?><br />
                                <?php echo $order['Customer']['phone'] ? 'tel.' . $order['Customer']['phone'] : ''; ?><br />
    
                            </div>
                        </div>
                   
    
                        <div class="summaryText clearfix">
                            <?php echo __d('public', 'Do zapłaty:'); ?>  
                            <b>
                                <?php //debug($order);  ?>
                                <?php $tmp = Commerce::getTotalPricesForOrder($order); ?>
                                <span id="razem-z-wysylka"><?php //echo str_replace(array('.00', '.'), array('', ','), ($tmp['final_price_gross']))    ?>
                                    <?php echo $this->Number->currency($tmp['final_price_gross'], 'EUR'); ?>
                                </span> 
                                <?php echo __d('public', '(brutto)'); ?>
                            </b>
                        </div>
                    </div>
            </div>
            </div>
        <?php } ?>

        <?php echo $content_for_view_2; ?>
        <div class="clearfix orders p10">
            <?php echo $this->Session->check('Auth.User.id') ? $this->Html->link('Moje zamówienie', array('controller' => 'customers', 'action' => 'order_item', $order['Order']['id'], 'plugin' => 'commerce'), array('class' => 'orangeButton2 fr')) : ''; ?>
            <?php echo $this->Html->link('Kolejne zamówienie', '/', array('class' => 'blueButton fl')); ?>
        </div>
</div>