<?php $product = json_decode($orderItem['product'], true); ?>
<?php $product_prices = Commerce::calculateByPriceType($orderItem['price'], $orderItem['tax_rate'], 1, $orderItem['discount']); ?>
<td class="itemIndex">    
    <?php echo empty($index) ? '' : $index . ")"; ?>
</td>
<td class="itemPhoto">
    <a href="<?php echo $this->Html->url(array('plugin' => 'static_product', 'controller' => 'products', 'action' => 'view', $product['Product']['slug'])); ?>" title="">
    <?php echo!empty($product['Photo']['img']) ? $this->Image->thumb('/files/photo/' . $product['Photo']['img'], array('width' => '135', 'height' => '100', 'frame' => '#fff')) : ''; ?>
    </a>
</td>
<td class="itemName">
    <?php //debug($orderItem); ?>
    <?php echo $orderItem['name']; ?>
    <?php if (!empty($orderItem['size'])): ?>
        <?php
//        $sizes = $product['Product']['size'];
//        $new_sizes = explode('|', $sizes);
        ?><br/>
        <small><?php echo __d('front', 'rozmiar'); ?>: <?php echo $orderItem['size']; /*$new_sizes[$orderItem['size']];*/ ?></small>
    <?php endif; ?>
</td>
<td class="itemQuantity quantity">
    <?php //debug($this->action);?>
    <?php //debug($product);?>
    <?php if ($this->action == 'cart' || $this->action == 'quantity') { ?>
        <?php echo $this->Form->input('Order.quantity', array('id' => 'OrderItemQuantity' . $orderItem['id'], 'value' => $orderItem['quantity'], 'type' => 'numeric', 'maxlength' => 3, 'label' => false)); /* 'after'=>$this->Html->image('Commerce.commerce/refresh.png', array(
          'onclick' => "quantityUpdate({$orderItem['id']})"
          )) */ ?>
        <script type="text/javascript">
            //<![CDATA[
            $('#<?php echo 'OrderItemQuantity' . $orderItem['id']; ?>').change(function() {
                var Lp_nr = $(this).parent().parent().siblings('.itemIndex').text();
                //console.log( '<>' +  $('#big-cart tbody tr td input').val() );
                <?php if (empty($product['Product']['sized']) && !empty($product['Product']['quantity'])): ?>
                    if (parseInt($(this).val()) > <?php echo $product['Product']['quantity'];?>) {
                        FEB.ui.flashMessage.setFlash('<?php echo __d('front', 'Maksymalna ilość produktów w tym rozmiarze wynosi '); ?><?php echo $product['Product']['quantity'];?>', 'error', 3000);                
                  //      alert('Maksymalna ilość produktu w tym rozmiarze wynosi <?php //echo $product['Product']['quantity'];?>');
                        $(this).val('<?php echo $product['Product']['quantity'];?>');
                        return false;
                    }
                <?php elseif (!empty($product['Product']['sized']) && !empty($orderItem['quantity'])): ?>
                    if (parseInt($(this).val()) > <?php echo $orderItem['quantity'];?>) {
                        FEB.ui.flashMessage.setFlash('<?php echo __d('front', 'Maksymalna ilość produktów w tym rozmiarze wynosi '); ?><?php echo $orderItem['quantity'];?>', 'error', 3000);
//                        alert('Maksymalna ilość produktu w tym rozmiarze wynosi <?php //echo $orderItem['quantity'];?>');
                        $(this).val('<?php echo $orderItem['quantity'];?>');
                        return false;
                    }
                <?php endif; ?>
                quantityUpdate(<?php echo $orderItem['id']; ?>, Lp_nr);
                return false;  
            });
            //]]>
        </script>
    <?php } else { ?>
        <?php echo $orderItem['quantity']; ?>
    <?php } ?>
</td>
<?php if ($this->action == 'cart' || $this->action == 'quantity' || $this->action == 'order_checkout') { ?>
    <td class="itemPriceFinal">
        <?php // echo $orderItem['tax_rate'] * 100 . '%'; ?>
        <?php // echo $this->Number->currency($orderItem['price_gross'] * $orderItem['quantity'], 'PLN') ?>
        <?php // echo $this->Number->currency($product_prices['final_price_gross'], 'PLN'); ?>
            <?php
            if (empty($order['PromotionCode']['value'])):
                if ($order['Customer']['discount'] > 0):
                    echo $this->FebNumber->currency($orderItem['quantity'] * $orderItem['price'] * (1 - $order['Customer']['discount'] / 100), ' ₴');
                else:
                    echo $this->FebNumber->currency($orderItem['quantity'] * $orderItem['price'], ' ₴');
                endif;
            else:
                if ($order['Customer']['discount'] > 0):
                    if ($order['PromotionCode']['value'] >= $order['Customer']['discount']):
                        echo $this->FebNumber->currency($orderItem['quantity'] * $orderItem['price'] * (1 - $order['PromotionCode']['value'] / 100), ' ₴');
                    else:
                        echo $this->FebNumber->currency($orderItem['quantity'] * $orderItem['price'] * (1 - $order['Customer']['discount'] / 100), ' ₴');
                    endif;
                else:
                    echo $this->FebNumber->currency($orderItem['quantity'] * $orderItem['price'] * (1 - $order['PromotionCode']['value'] / 100), ' ₴');
                endif;
            endif;
            ?>
        <script type="text/javascript">
            $(function() {
                var price_gross = '<?php echo $total['price_gross']; ?>';
                $('#razem-bez-wysylki').attr('total', price_gross);
                price_gross = parseFloat(price_gross).toFixed(2);
                $('#razem-bez-wysylki').html(price_gross.replace('.', ',') + ' ₴');
                //                $('#podatek_calosc').attr('total', '<?php //echo $total['tax'];  ?>');
                                
                var total_gross = '<?php echo $total['gross']; ?>';
                $('#price-after-promo').attr('bonus', total_gross);
                total_gross = parseFloat(total_gross).toFixed(2);
                $('#price-after-promo').html(total_gross.replace('.', ',') + ' ₴');
                
                updateTotalPrice($('#sendMetodCartForm :radio:checked'));
            });
        </script>
    </td>
    <?php if ($this->action == 'cart' || $this->action == 'quantity') { ?>
        <td class="itemDeleteTD deleteTD">
            <?php echo $this->Html->link('x ' . __d('public', 'Usuń'), array('action' => 'delete', $orderItem['id']), array('class' => 'deleteFile')); ?>&nbsp;<?php echo $this->Js->writeBuffer(); ?>
        </td>
    <?php } ?>
<?php } else { ?>
    <td class="itemPriceFinal">
        <?php //echo $this->Number->currency($product_prices['final_price_gross'] * $orderItem['quantity'], /*'PLN '*/ 'EUR ');  ?>    
        <?php //echo Configure::read('Config.language') == 'pol' ? 'EUR ' . number_format($product_prices['final_price_gross'], 2, ',', '') : 'EUR ' . number_format($product_prices['price_net'], 2, ',', '');   ?>

        <?php echo $this->FebNumber->currency($product_prices['final_price_gross'] * $orderItem['quantity'], ' ₴') ?>
        <script type="text/javascript">
            $(function() {
                var price_gross = '<?php echo $total['price_gross']; ?>';
                $('#razem-bez-wysylki').attr('total', price_gross);
                price_gross = parseFloat(price_gross).toFixed(2);
                $('#razem-bez-wysylki').html(price_gross.replace('.', ',') + ' ₴');
                //                $('#podatek_calosc').attr('total', '<?php //echo $total['tax'];  ?>');
                
                var total_gross = '<?php echo $total['gross']; ?>';
                $('#price-after-promo').attr('bonus', total_gross);
                total_gross = parseFloat(total_gross).toFixed(2);
                $('#price-after-promo').html(total_gross.replace('.', ',') + ' ₴');
                
                updateTotalPrice($('#sendMetodCartForm :radio:checked'));
            });
        </script>
    </td>
<?php } ?>