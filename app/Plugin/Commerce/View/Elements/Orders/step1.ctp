<?php if (!empty($order['OrderItem'])): ?>
    <table id="cartBig" class="orders" style="width: 100%;" cellpadding="0" cellspacing="0">
        <thead>
            <tr class="border-bottom">
                <th width='25px' class="productIndex"></th>
                <th class="productProduct textCenter" colspan="2"><?php echo __('Produkty');?></th>
                <!--<th class="productProduct textCenter" >Produkty</th>-->
                <th class="productQuantity"><?php echo __('Ilość'); ?></th>
                <th class="productPriceFinal"><?php echo __('Cena finalna'); ?></th>
                <?php if ($this->action == 'cart' || $this->action == 'quantity'): ?>
                    <th class="productDelete"></th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php $i = 0; ?>
            <?php $index = 0; ?>
            <?php foreach ($order['OrderItem'] as $orderItem): ?>
                <?php $index++; ?>
                <?php $class = ($i++ % 2) ? ' class="altrow"' : ''; ?>
                <tr class="productRow" <?php echo 'id="' . 'quantity' . $orderItem['id'] . '"' ?>>
                    <?php echo $this->element('Orders/order_product', compact('orderItem', 'order', 'index')); ?>
                </tr>
            <?php endforeach; ?>  
            <?php // debug($shipmentMethods); ?>
            <tr class="productRow summaryRow border-top border-bottom">
                <td class="itemIndex">&nbsp;</td>
                <td class="itemPhoto"><?php echo __('DOSTAWA');?></td>
                <td class="itemName"><?php echo $shipmentMethods[$this->data['Order']['shipment_method_id']]['ShipmentMethod']['name']; ?></td>
                <td class="itemQuantity ">&nbsp;</td>
                <td class="itemPriceFinal">
                    <?php
                    $bonusFactor = 0;
                    if (!empty($order['PromotionCode']['value'])) {
                        if (!empty($order['Customer']['discount'])) {
                            $bonusFactor = $order['PromotionCode']['value'] >= $order['Customer']['discount'] ? $order['PromotionCode']['value'] : $order['Customer']['discount'];
                        } else {
                            $bonusFactor = $order['PromotionCode']['value'];
                        }
                    } else {
                        $bonusFactor = empty($order['Customer']['discount']) ? 0 : $order['Customer']['discount'];
                    }
                    $shipmentPriceGross = $shipmentMethods[$this->data['Order']['shipment_method_id']]['ShipmentMethod']['final_price_gross'];
                    $shipmentPriceBonus = $shipmentPriceGross - $shipmentPriceGross * $bonusFactor / 100;
                    ?>
                    <?php //echo $this->Number->currency($shipmentMethods[$this->data['Order']['shipment_method_id']]['ShipmentMethod']['final_price_gross'], 'PLN'); ?>
                    <?php //echo $this->Number->currency($shipmentPriceBonus, 'PLN'); ?>
                    <?php echo $this->FebNumber->currency($shipmentPriceGross, ' ₴'); ?>
                </td>
            </tr>
            <tr id="cash_on_delivery_price_tr" style="display:none;" class="productRow summaryRow border-top border-bottom">
                <td class="itemPhoto" colspan="2"><?php echo __('Metoda płatności');?></td>
                <td class="itemPrice"><?php echo __('Płatność za pobraniem/przy odbiorze');?></td>
                <td class="itemQuantity ">&nbsp;</td>
                <td class="itemPriceFinal"></td>
            </tr>
        </tbody>     
    </table>

    <?php //echo $this->Fancybox->init('jQuery("a.cartItemDetails")', array(), true); ?>

    <div class="widthCenter clearfix">

        <?php
//        $shipmentMethodOptions = array();
        //debug($shipmentMethods);
        foreach ($shipmentMethods as $value) {
            $shipmentMethodOptions[$value['ShipmentMethod']['id']] = array('price' => $value['ShipmentMethod']['final_price_gross'], 'price_on_delivery' => $value['ShipmentMethod']['cash_on_delivery_price'], 'name' => $value['ShipmentMethod']['name'], 'tax_rate' => $value['ShipmentMethod']['tax_rate']);
        }
        //debug($shipmentMethodOptions);
        ?>
        <script type="text/javascript">
            var gPromotionCodeValue = <?php echo empty($order['PromotionCode']['value']) ? 0 : $order['PromotionCode']['value']; ?>;
            var gCustomerDiscount = <?php echo empty($order['Customer']['discount']) ? 0 : $order['Customer']['discount']; ?>;


            function updateTotalPrice() {
                var shipments = <?php echo json_encode($shipmentMethodOptions); ?>;

                //                var selected = $('.shipment-price').val();
                var selected = $('.itemPriceFinal').text();
                var price = 0;
                for (key in shipments) {
                    if (selected == key) {
                        $('#sendMethod').text(shipments.ShipmentMethod.name);
                    }
                }
                price = <?php echo $shipmentMethods[$this->data['Order']['shipment_method_id']]['ShipmentMethod']['final_price_gross']; ?>;
                var payment_id = $('.orderPaySelect input:checked').attr('value');
                if (payment_id == 2) {
                    price += cash_on_delivery_price; // * 1.23;
                }

                /*var shipmentDiscount = 0;
                if (gPromotionCodeValue) {
                    if (gCustomerDiscount) {
                        shipmentDiscount = (gPromotionCodeValue >= gCustomerDiscount) ? gPromotionCodeValue : gCustomerDiscount;
                    } else {
                        shipmentDiscount = gCustomerDiscount;
                    }
                } else {
                    shipmentDiscount = (gCustomerDiscount) ? gCustomerDiscount : 0;
                }
                price = price - price * (parseFloat(shipmentDiscount) / 100);*/

                $('#shipmentCost').html(FEB.currency_format((price).toFixed(2), ' ₴'));
                $('#razem-z-wysylka').html(((((parseFloat($('#razem-bez-wysylki').attr('total').replace(',', '.').replace(' ', '')) + price).toFixed(2))) + "").replace('.', ',') + ' ₴');

                $('#sendMethod').html('<?php echo $shipmentMethods[$this->data['Order']['shipment_method_id']]['ShipmentMethod']['name']; ?>');
            }

            $(function() {
                //                var payment = <?php // echo json_encode($shipmentMethodOptions);      ?>;
                //console.debug(payment);
                var txt_WybierzSposob = "<?php echo __('Wybierz sposób wysyłki') ?>";
                $('#razem-z-wysylka').html('<i>' + txt_WybierzSposob + '</i>');

                $('.shipment-price').change(function() {
                    updateTotalPrice();
                });
                //console.debug(payment);
                //                $('.updatePrices').click(function(){
                //                                                                      
                //                    var paymentType = $(this).val();  
                //                    if (paymentType != 2) {
                //                        $('.shipment-price option').each(function(obj, b) {                                    
                //                            $(b).text(payment[$(b).attr('value')].name + ' ' + parseFloat(payment[$(b).attr('value')].price).toFixed(2).replace(".", ",") + ' ₴');                           
                //                        });  
                //                    } else { // if (paymentType == 1) {
                //                        $('.shipment-price option').each(function(obj, b){
                //                            $(b).text(payment[$(b).attr('value')].name + ' ' + (parseFloat(payment[$(b).attr('value')].price_on_delivery) + parseFloat(payment[$(b).attr('value')].price)).toFixed(2).replace(".", ",") + ' ₴');                            
                //                        });  
                //                    }
                //                    updateTotalPrice();                               
                //                });

                updateTotalPrice();
            });

            function quantityUpdate(id) {
                jQuery.ajax({
                    url: '<?php echo $this->Html->url(array('action' => 'quantity')) ?>' + '/' + id,
                    data: jQuery('#quantity' + id + ' input').serialize(),
                    dataType: 'html',
                    type: "POST",
                    success: function(data) {
                        jQuery('#quantity' + id).html(data);
                    }
                });
            }

        </script>
        <?php
//        $shipmentMethodOptionsShow = array();
        //debug($shipmentMethods);
//        foreach ($shipmentMethods as $k => $value) {
//            $img = empty($value['ShipmentMethod']['img']) ? '' : $this->Html->image('/files/shipmentmethod/' . $value['ShipmentMethod']['img']);
//            $shipmentMethodOptionsShow[$value['ShipmentMethod']['id']] = $value['ShipmentMethod']['name'] . ' ' . number_format($value['ShipmentMethod']['final_price_gross'], 2, ',', '') . ' ₴';
//        }
        ?>


        <?php //echo $this->Form->create('Order');  ?>
        <div id="sendMetodCartForm">
            <!--            <div class="radioType">
            <?php echo $this->Form->input('Order.shipment_method_id', array('label' => __('Wybierz sposób dostawy') . ':', 'type' => 'select', 'options' => $shipmentMethodOptionsShow, 'class' => "shipment-price")); ?>
            <?php echo $this->Form->hidden('Order.shipment_price', array('id' => 'shipmentPrice')); ?>
                        </div>-->
        </div>

        <?php //echo $this->Form->end();  ?>
    </div>
<?php endif; ?>
<?php //echo $this->Html->link('<h1 class="green">Dalej</h1>', array('plugin' => 'commerce', 'controller' => 'customers', 'action' => 'add'), array('escape'=>false,'class'=>'fr'));  ?>
