<?php $this->Html->addCrumb(__d('front', 'Strona główna'), '/'); ?>
<?php $this->Html->addCrumb(__d('front', 'Twoje zamówienia'), array('plugin' => 'commerce', 'controller' => 'customers', 'action' => 'my_orders_active')); ?>
<?php $this->Html->addCrumb(__d('front', 'Podgląd zamówienia')); ?>

    <?php $order = $actualOrder; ?>
<?php $title = __d('front', 'PODGLĄD ZAMÓWIENIA NUMER').': ' . $order['Order']['hash']; ?>
<?php $this->set('title_for_layout', $title); ?>
<?php echo $this->Html->css('ui-lightness/jquery-ui-1.8.14.custom', null, array('inline' => false)) ?>
<?php echo $this->Html->script('jquery-ui-1.8.14.custom.min', array('inline' => false)) ?>
<?php // echo $this->Html->css('/commerce/css/commerce', null, array('inline' => false))    ?>
<div id="my-account" class="clearfix orders">
    <div class="row-fluid">
        <div class="breadcrump span12 bt-no-margin">
            <span class="navi"><?php echo __d('front', 'NAVIGATION'); ?>:</span> <?php echo $this->Html->getCrumbList(array('class' => 'breadcrumb')); ?>
        </div>
    </div>
    <div class="white-background  clearfix">
        <div class="clearfix">
            <div class="border-page padding20">
                <h2><?php echo $title ?></h2>
                <div class="blueNav">
                    <?php echo $this->element('customer/menu'); ?>
                </div>
                <div class="orders">
                    <table id="cartBig" class="orders" style="width: 100%;">
                        <thead>
                            <tr class="productRow padding20">
                                <th class="productProduct textCenter" colspan="2"><?php // echo __d('front', 'Produkty'); ?></th>
                                <th class="productPrice"><?php // echo __d('front', 'Cena jednostkowa'); ?><?php echo __d('front', 'Produkty'); ?></th>
                                <th class="productQuantity"><?php echo __d('front', 'Ilość'); ?></th>
                                <th class="productPriceFinal"><?php echo __d('front', 'Cena finalna'); ?></th>
                            </tr>
                        </thead>
                        <?php
                        $key = 0;
//            debug($order);
                        foreach ($order['OrderItem'] as $key => $orderItem):
                            ?>
                            <?php // echo $this->element($orderItem['product_plugin'].'.Commerce/OrderItemDetails', array('orderItem' => $orderItem, 'order' => $order));  ?>
                            <tr class="productRow border-top">
                                <?php echo $this->element('Orders/order_product', compact('orderItem')); ?>
                            </tr>
                        <?php endforeach; ?>
                        <tr class="productRow">
                            <td class="itemPhoto"></td>
                            <td class="itemName"><b><?php echo __d('front', 'Sposób dostawy'); ?>:</b> <?php echo $order['ShipmentMethod']['name']; ?></td>
                            <td class="itemPrice"><?php echo $this->Number->currency($order['Order']['shipment_price_net'], ' ₴'); ?></td>
                            <td class="itemQuantity ">1</td>
                            <td class="itemPriceFinal"><?php echo $this->Number->currency($order['Order']['shipment_price_gross'], ' ₴'); ?></td>
                        </tr>
                        <tr class=" border-top padding10">
                            <td colspan="1"></td>
                            <td colspan=""></td>
                            <td colspan="" class="textCenter bold uppercase"><?php echo __d('front', 'Suma'); ?></td>
                            <td colspan=""></td>
                            <td class="itemPriceFinal"><?php echo $this->Number->currency($order['Order']['total'], ' ₴'); ?></td>                    
                        </tr>
                        <tbody>
                    </table>
                </div>   

                <!--    <div>
                <?php // echo $this->Html->link(__d('public', 'Szczegóły zamówienia (do druku)'), array('action' => 'order_details', $order['Order']['id'])); ?>
                    </div>-->

            </div>
        </div>
    </div>
</div>