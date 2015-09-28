<?php echo $this->Html->script('/commerce/js/webtoolkit.aim'); ?>
<script type="text/javascript">  
    var messageBlock = { 
        message: ' Ładowanie... <?php echo $this->Html->image('layouts/default/ajax-loader.gif', array('alt' => '...', 'style' => 'vertical-align:middle;display:inline;')); ?>',
        css:  { 
            border: 'none', 
            padding: '15px', 
            backgroundColor: '#000', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
            'border-radius': '10px', 
            opacity: .5, 
            color: '#fff' 
        }  
    };
    
    function completeCallbackUpdate(response, formId) {
        $('#'+formId).parents('tr').unblock();
        $('#'+formId).parents('.fileInfoCont').html(response);
    }
    function completeCallbackNew(response, formId) {
        $('#'+formId).parents('tr').unblock();
        $('#'+formId).parents('td').html(response);
    }
    function startCallbackUpdate(thisForm){
        //console.debug($(thisForm).parent().parent());
        $(thisForm).parents('tr').block(messageBlock);
        /*$(thisForm).parents('.fileInfoCont').parent().parent().block({
            message: '<?php echo $this->Html->image('layouts/default/ajax-loader.gif', array('alt' => '...', 'style' => 'vertical-align:middle;display:inline;')); ?> Ładowanie...',
            css: { border: '0px none', padding: '0px', background: 'transparent' }             
        }); */
    }
    function startCallbackNew(thisForm){
        $(thisForm).parents('tr').block(messageBlock);

    }
</script>
<?php $cartLink = array('plugin' => 'commerce', 'controller' => 'orders', 'action' => 'cart'); ?> 
<div class="cartSmall">
    <?php if (empty($order)): ?>
        <?php $order = $this->Html->requestAction(array('plugin' => 'commerce', 'controller' => 'orders', 'action' => 'mini_cart', 'admin' => false, 'user' => false)); ?>
    <?php endif; ?>
    <?php if (!empty($order['OrderItem'])): ?>
        <?php //echo $this->Html->link('Koszyk', $cartLink, array('class'=>'fl')); ?> 

        <div id="cartMenu">
            <?php echo $this->Html->image('layouts/default/ico7.png'); ?>
            <?php echo $countProd = count($order['OrderItem']); ?> Anzahl
        </div>
        <div id="cartSumme">
            <?php $total = Commerce::getTotalPricesForOrder($order); ?>
            <?php $total = $this->FebNumber->priceFormat($total['final_price_gross']); ?>
            Summe: <span><?php echo $this->Number->currency($total, ' ₴', array('wholePosition' => 'after', 'after' => true, 'decimals' => ',')); ?></span>
        </div>
        <div id="cartCash">
            Kasse
        </div>

        <div class="cartContentSmall br-all">
            <table>
                <thead>
                    <tr>
                        <th>Beschreibung</th>
                        <th></th>
                        <th>Summe netto </th>
                        <th>Anzahl:</th>
                        <th>MwSt.</th>
                        <th>Summe brutto</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($order['OrderItem'] as $orderItem) {
                        $tmpPrice = Commerce::calculateByPriceType($orderItem['price'], $orderItem['tax_rate'], $orderItem['quantity'], $orderItem['discount']);
                        ?>
                        <tr class="productSmallOrderItem">
                            <?php $product = json_decode($orderItem['product'], true); ?>

                            <td class="photoCartMin">
                                <?php
                                echo!empty($product['Photo']['img']) ? $this->Image->thumb('/files/photo/' . $product['Photo']['img'], array('width' => '135', 'height' => '100', 'frame' => '#fff')) : '';
//debug($product);
                                echo!empty($product['WindowConfiguration']['id']) ? $this->element('Window.WindowConfigurations/draw', array(
                                            'windowConfiguration' => $product,
                                            'objectID' => 'mainDraw' . $product['WindowConfiguration']['id'],
                                            'destWidth' => 100,
                                            'destHeight' => 80,
                                        )) : '';
                                echo!empty($product['FabricStyle']['id']) ? $this->Image->thumb('/files/fabricstyle/' . $product['FabricStyle']['img'], array('width' => '100', 'height' => '80', 'frame' => '#fff')) : '';
                                ?>
                            </td>
                            <td class="nameCartMin">
                                <?php echo empty($product['WindowConfiguration']['id']) ? '<h2>' . $orderItem['name'] . '</h2>' : $this->element('Window.Commerce/OrderItemFullDescription', compact('orderItem')); ?>
                            </td>
                            <td class="quantityCartMin">
                                <?php echo ($orderItem['quantity']) ?> <?php __d('public', 'sztuki'); ?> <?php echo $orderItem['desc']; ?>
                            </td>
                            <td class="summeCartPriceNet">
                                <?php echo $this->FebNumber->priceFormat($tmpPrice['final_price_net']); ?>
                            </td>
                            <td class="priceCartMin">
                                <?php echo ($orderItem['tax_rate'] * 100) . '%'; ?>
                            </td>
                            <td class="summeCartMin">
                                <?php echo $this->FebNumber->priceFormat($tmpPrice['final_price_gross']); ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div class="productSmallOrderItem toCash clearfix">
                <?php echo $this->Html->link('Do kasy »', $cartLink); ?>
            </div>
        </div>
    <?php else: ?>
        <div id="cartMenu">
            <?php echo $this->Html->image('layouts/default/ico7.png'); ?>
            <?php echo '0 ' . __n('Anzahl', 'Anzahl', 0); ?> 
        </div>
        <div id="cartSumme">
            <?php $total = 0 ?>
            <?php $total = $this->FebNumber->priceFormat($total['final_price_gross']); ?>
            Summe: <span><?php echo $this->Number->currency($total, ' ₴', array('wholePosition' => 'after', 'after' => true, 'decimals' => ',')); ?></span>
        </div>
        <div id="cartCash">
            Kasse
        </div>

    <?php endif; ?>

</div>

