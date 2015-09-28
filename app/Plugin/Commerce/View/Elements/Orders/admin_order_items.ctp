<script>
    $(document).ready(function() {   
        var data = {}
        data = <?php echo json_encode($this->request->data) ?>;
        gdata = {data : data};
         
        var configm_text = "<?php echo __d('cms', 'Faktura została już wygenerowana. Pomimo tego chcesz zmienić zamówienie?');?>";
        //        $('#OrderShipmentPriceNet').val(gdata.data.Order.shipment_price_net);
        //        $('#OrderShipmentPriceGross').val(gdata.data.Order.shipment_price_gross);
        //        

//        $('#OrderShipmentPriceGross').change(function(){
//            var toSend = {
//                data: {
//                    Order: {
//                        id: gdata.data.Order.id,
//                        shipment_price: $(this).attr('value')
//                    }
//                }
//            };
//            changeOrder('<?php echo $this->Html->url(array('action' => 'ajaxedit')) ?>', toSend, $('#orders-items'), function(){
//            });
//            return false;
//        });   
            
        $('#shipment_method_id').change(function(){
            var toSend = {
                data: {
                    Order: {
                        id: gdata.data.Order.id,
                        shipment_method_id: $(this).attr('value')
                    }
                }
            };
            changeOrder('<?php echo $this->Html->url(array('action' => 'ajaxedit')) ?>', toSend, $('#orders-items'), function(){
                //                    window.location.reload();                     return false;
            });
            return false;
        });   
            
            
        $('.updatePrices').change(function(){
            //            myThis = $(this);
            //            console.debug(jQuery(this).attr('value'));
                
            var toSend = {
                data: {
                    Order: {
                        id: gdata.data.Order.id,
                        payment_type: $(this).attr('value')
                    }
                }
            };
            changeOrder('<?php echo $this->Html->url(array('action' => 'ajaxedit')) ?>', toSend, $('#orders-items'), function(){
                //myThis.attr('checked','checked');
                //console.debug(myThis);
            });
            //myThis.attr('checked','checked');
            return true;
        });        
            
            
        //        $('.ajaxEditDiscount').editable(function(value, settings) {
        //            if (value > 100) value = 100;
        //            if (value < 0) value = 0;
        //                            
        //            var toSend = {
        //                data: {
        //                    Order: {
        //                        id: gdata.data.Order.id
        //                    },
        //                    OrderItem: {
        //                        id: $(this).parent().attr('orderelement'),
        //                        discount: value
        //                    }
        //                }
        //            };
        //            changeOrder('<?php echo $this->Html->url(array('action' => 'ajaxedit')) ?>', toSend, $('#orders-items'))
        //            return value;
        //        }, {  
        //            width: '40px',
        //            type     : 'textarea',
        //            submit   : 'OK'
        //        }); 
        
        $('.ajaxEditName').editable(function(value, settings) {
            var toSend = {
                data: {
                    Order: {
                        id: gdata.data.Order.id
                    },
                    OrderItem: {
                        id: $(this).parents('tr').attr('orderelement'),
                        name: value
                    }
                }
            };
            changeOrder('<?php echo $this->Html->url(array('action' => 'ajaxedit')) ?>', toSend, $('#orders-items'))
            return value;
        }, {  
            width: '240px',
            type     : 'textarea',
            submit   : 'OK'
        });
        $('.ajaxEditQuantity').editable(function(value, settings) {
            var toSend = {
                data: {
                    Order: {
                        id: gdata.data.Order.id
                    },
                    OrderItem: {
                        id: $(this).parent().attr('orderelement'),
                        quantity: value
                    }
                }
            };
            changeOrder('<?php echo $this->Html->url(array('action' => 'ajaxedit')) ?>', toSend, $('#orders-items'))
            return value;
        }, {  
            width: '40px',
            type     : 'textarea',
            submit   : 'OK'
        });
                $('.ajaxEditPrice').editable(function(value, settings) {
             
                    var toSend = {
                        data: {
                            Order: {
                                id: gdata.data.Order.id
                            },
                            OrderItem: {
                                id: $(this).parent().attr('orderelement'),
                                price: parseFloat(value.replace(',', '.'))
                            }
                        }
                    };            
                    changeOrder('<?php echo $this->Html->url(array('action' => 'ajaxedit')) ?>', toSend, $('#orders-items'));
                    return value;
                }, {  
                    data: function(value, settings) {
                        var retval = value.replace(' ', '').replace('₴', '');
                        return retval;
                    },
                    width: '40px',
                    type     : 'text',
                    submit   : 'OK'
                });
            
          
                $('.ajaxEditVat').editable(function(value, settings) {
             
                    var toSend = {
                        data: {
                            Order: {
                                id: gdata.data.Order.id
                            },
                            OrderItem: {
                                id: $(this).parent().attr('orderelement'),
                                tax_rate: parseFloat(value.replace(',', '.'))
                            }
                        }
                    };            
                    changeOrder('<?php echo $this->Html->url(array('action' => 'ajaxedit')) ?>', toSend, $('#orders-items'));
                    return value;
                }, {  
                    data: function(value, settings) {
                        var retval = value.replace(' ', '').replace('₴', '');
                        var arra = <?php echo json_encode(Order::$taxRates); ?>;
                        arra['selected'] = parseInt(value)/100;
                        return arra;
                    },
                    width: '40px',
                    type     : 'select',
                    submit   : 'OK'
                });          
          
        //        $('.ajaxEditShipmentDiscount').editable(function(value, settings) {
        //            
        //            if (value > 100) value = 100;
        //            if (value < 0) value = 0;
        //            var toSend = {
        //                data: {
        //                    Order: {
        //                        id: gdata.data.Order.id,
        //                        shipment_discount: value
        //                    }
        //                }
        //            };            
        //            changeOrder('<?php echo $this->Html->url(array('action' => 'ajaxedit')) ?>', toSend, $('#orders-items'));
        //            return '';
        //        }, {  
        //            width: '40px',
        //            type     : 'textarea',
        //            submit   : 'OK'
        //        });
            
        //        $('.ajaxEditShipmentPriceGross').editable(function(value, settings) {
        //            var toSend = {
        //                data: {
        //                    Order: {
        //                        id: gdata.data.Order.id,
        //                        shipment_price: value
        //                    }
        //                }
        //            };            
        //            changeOrder('<?php echo $this->Html->url(array('action' => 'ajaxedit')) ?>', toSend, $('#orders-items'));
        //            return '';
        //        }, {  
        //            width: '40px',
        //            type     : 'textarea',
        //            submit   : 'OK'
        //        });
            
        //        $('.ajaxSetAllDiscount').editable(function(value, settings) {
        //            if (value > 100) value = 100;
        //            if (value < 0) value = 0;
        //            var toSend = {
        //                data: {
        //                    Order: {
        //                        id: gdata.data.Order.id,
        //                        discount: value
        //                    }
        //                }
        //            };            
        //            changeOrder('<?php echo $this->Html->url(array('action' => 'ajaxedit')) ?>', toSend, $('#orders-items'));
        //            return '';
        //        }, {  
        //            width: '40px',
        //            type     : 'textarea',
        //            submit   : 'OK',
        //            placeholder: 'Kliknij aby ustawić'
        //        });
            
    });
</script>


<?php echo $this->Html->link(__d('commerce', 'Szczegóły zamówienia'), array('action' => 'view', $this->request->data['Order']['id'])); ?>
<br />
<?php //echo $this->Html->link(__d('commerce', 'Specyfikacja zamówienia'), array('action' => 'specification', $this->request->data['Order']['id'])); ?>
<table class="orderItem-table">
    <tr>
        <th><?php echo __d('commerce', 'Nazwa') ?></th>
        <th><?php echo __d('commerce', 'Ilość') ?></th>
        <th><?php echo __d('commerce', 'Cena Netto') ?></th>
        <th><?php echo __d('commerce', 'VAT') ?></th>
        <th colspan="2"><?php echo __d('commerce', 'Cena Brutto') ?></th>
        <th><?php echo __d('commerce', 'Rabat')  ?>&nbsp<span class="ajaxSetAllDiscount"></span>[%]</th>
        <th><?php echo __d('commerce', 'Razem bez rabatu')  ?></th>
        <th colspan="2"><?php echo __d('commerce', 'Razem') ?></th>
    </tr>
    <?php foreach ($this->request->data['OrderItem'] as $orderItem): ?>    
        <?php
        $product = json_decode($orderItem['product'], true);
//        debug($product); 
        ?>
        <?php $priceDetalis = Commerce::calculateByPriceType($orderItem['price'], $orderItem['tax_rate'], 1) ?>

        <tr orderelement ="<?php echo $orderItem['id']; ?>">
            <td><b><span class="ajaxEditName"><?php echo $orderItem['name']; ?></span></b> <?php echo (!empty($orderItem['size'])) ? '<small>('.__d('cms', 'rozmiar').': '.$orderItem['size'].')</small>' : '';?></td>
            <td class="ajaxEditQuantity"><?php echo $orderItem['quantity']; ?></td>
            <td class="ajaxEditPrice"><?php echo $this->Number->currency($priceDetalis['price_net'], 'PLN'); ?></td>
            <td class="ajaxEditVat"><?php echo ($orderItem['tax_rate'] * 100) . '%'; ?></td>
            <td colspan="2"><?php echo $this->Number->currency($priceDetalis['price_gross'], 'PLN'); ?></td>
            <td class="ajaxEditDiscount"><?php echo $orderItem['discount']; ?></td>
            <td><?php echo $this->FebNumber->priceFormat(Commerce::getPriceForEachOrderItem($priceDetalis['price_gross'], $orderItem['quantity'])); ?></td>
            <td colspan="2"><b><?php echo $this->Number->currency(Commerce::getPriceForEachOrderItem($priceDetalis['price_gross']*((100-$orderItem['discount'])/100), $orderItem['quantity']), 'PLN'); ?></b></td>
        </tr>
    <?php endforeach ?>
    <?php
//    debug($this->request->data);
    $orderItemPrice = Commerce::getTotalPricesForOrder($this->request->data);
    $shipmentPrices = Commerce::calculateByPriceType($this->request->data['Order']['shipment_price'], $this->request->data['Order']['shipment_tax_rate'], 1, $this->request->data['Order']['shipment_discount']);
    ?>
    <tr>
        <th colspan="2"><?php echo __d('commerce', 'Wysyłka i transport') ?>:</th>
        <td colspan="4"></td>
        <th colspan="2" style="text-align: right"><?php echo __d('commerce', 'Wartość Zamówienia') ?>:</th>
        <td><b><?php echo $this->Number->currency($orderItemPrice['final_price_gross'], 'PLN'); ?></b></td>
    </tr>

    <tr>
        <td colspan="2"><?php echo $this->Form->input('shipment_method_id', array('label' => false, 'id' => 'shipment_method_id', 'options' => $shipmentMethods, 'selected' => $order['shipment_method_id'])); ?></td>
        <td class="ajaxEditShipmentPriceGross" ><?php echo $this->Number->currency($this->request->data['Order']['shipment_price_net'], 'PLN'); ?></td>
        <td><?php echo ($this->request->data['Order']['shipment_tax_rate'] * 100) . '%'; ?></td>
        <td colspan="2"><?php echo $this->Number->currency($shipmentPrices['price_gross'], 'PLN'); ?></td>
        <td class="ajaxEditShipmentDiscount"><?php echo $this->request->data['Order']['shipment_discount']; ?></td>
        <th><?php echo __d('cms', 'Koszt dostawy'); ?>:</th>
        <th><b><?php echo $this->Number->currency($shipmentPrices['final_price_gross'], 'PLN'); ?></b></th>
    </tr>
    <?php if ($this->request->data['Order']['provision']): ?>
        <tr>
            <td colspan="2"><?php echo __d('cms', 'Wartość prowizji'); ?></td>
            <td class="ajaxEditPrice"><?php echo $this->Number->currency($this->request->data['Order']['provision_total'], 'PLN'); ?></td>
            <td>23%</td>
            <td colspan="2"><?php echo $this->Number->currency($this->request->data['Order']['provision_total'] * 1.23, 'PLN'); ?></td>
            <!--<td class="ajaxEditDiscount"><?php echo $orderItem['discount']; ?></td>-->
            <!--<td><?php echo $this->FebNumber->priceFormat(Commerce::getPriceForEachOrderItem($priceDetalis['price_gross'], $orderItem['quantity'])); ?></td>-->
            <th><?php echo __d('cms', 'Wartość prowizji'); ?> 2%</th>
            <td><b><?php echo $this->Number->currency($this->request->data['Order']['provision_total'] * 1.23, 'PLN'); ?></b></td>
        </tr>
    <?php endif; ?>
    <tr>
        <td colspan="6">
            <div class="radioInline">
                <?php
                $attributes = array('legend' => false, 'class' => 'updatePrices');
                echo $this->Form->radio('Order.payment_type', $paymentTypes, $attributes);
                ?>
            </div>
        </td>
        <th style="text-align: right"  colspan="2"><?php echo __d('commerce', 'Do Zapłaty') ?>:</th>
        <?php
//            debug($this->request->data);
        $total = Commerce::getTotalPricesForOrder($this->request->data);
        $total = $this->request->data['Order']['total'];
//        debug($total);
        ?>
        <td id="total-price" valign="middle" ><?php echo $this->Number->currency($total, 'PLN') ?></td>
    </tr>

    <tr>
        <td colspan="8" style="text-align: right"><?php echo __d('commerce', 'Zapłacono') ?>:</td>
        <th><b><?php echo $this->Number->currency($paymentTotal, 'PLN'); ?></b></th>
    </tr>
    <?php if (($total - $paymentTotal) > 0) { ?>
        <tr>
            <td colspan="8" style="text-align: right"><?php echo __d('commerce', 'Pozostało') ?>:</td>
            <th><?php echo $this->Number->currency(($total - $paymentTotal), 'PLN'); ?></th>
        </tr>
    <?php } ?>
</table>

