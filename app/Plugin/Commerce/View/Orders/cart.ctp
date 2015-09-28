<?php $this->set('title_for_layout', __d('public', 'Podgląd koszyka')); ?>
<?php $this->Html->addCrumb(__d('public', 'Strona główna'), '/'); ?>
<?php $this->Html->addCrumb(__d('public', 'Podgląd koszyka')); ?>

<?php echo $this->Form->create('Order'); ?>
<div id="cart" class="clearfix orders">
    <div class="row-fluid">
        <div class="breadcrump span12 bt-no-margin">
            <span class="navi"><?php echo __d('public', "NAVIGATION"); ?>:</span> <?php echo $this->Html->getCrumbList(array('class' => 'breadcrumb')); ?>
        </div>
    </div>
    <div class="white-background clearfix">
        <div class="clearfix">
            <div class="cart-navi border-page row-fluid clearfix">
                <span class="active">1. <?php echo __d('public', 'Twój koszyk'); ?></span> <i class="icon-arrow-right"></i> <span>2. <?php echo __d('public', 'Składanie zamówienia'); ?></span> <i class="icon-arrow-right"></i> <span>3. <?php echo __d('public', 'Podsumowanie zakupu'); ?></span>
            </div>
            <div class="border-page">
                <table id="big-cart" class="orders" style="width: 100%;">
                    <thead>
                        <tr class="border-bottom">
                            <th class="productIndex"></th>
                            <th class="productPhoto"></th>
                            <th class="productProduct"><?php echo __d('public', 'Produkt'); ?></th>
                            <th class="productQuantity"><?php echo __d('public', 'Ilość'); ?></th>
                            <th class="productPriceFinal"><?php echo __d('public', 'Wartość'); ?></th>
                            <th class="productDelete"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $index = 0; ?>
                        <?php foreach ($order['OrderItem'] as $orderItem): ?>
                            <?php $index++; ?>
                            <tr id="<?php echo 'quantity' . $orderItem['id']; ?>" class="productRow">
                                <?php echo $this->element('Orders/order_product', compact('orderItem', 'index')); ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php //echo $this->element('Orders/summary_table-old', compact('order'));?>
                <div class="summary clearfix padding20">
                    <?php echo $this->element('Orders/summary_table', compact('order')); ?>
                </div>

                <div class="shipmentMethods clearfix">
                    <h3><?php echo __('Wybierz poniżej formę płatności i dostawy'); ?></h3>
                    <div class="border-page no-border-bottom padding20 clearfix">
                        <div class="shipment" style="float:left">
                            <?php
                            $shipmentMethodOptionsShow = array();

                            foreach ($shipmentMethods as $k => $value) {
                                $img = empty($value['ShipmentMethod']['img']) ? '' : $this->Html->image('/files/shipmentmethod/' . $value['ShipmentMethod']['img']);
                                $shipmentMethodOptionsShow[$value['ShipmentMethod']['id']] = $value['ShipmentMethod']['name'] . ' ' . $this->FebNumber->currency($value['ShipmentMethod']['final_price_gross'], ' ₴');
                            }
                            ksort($shipmentMethodOptionsShow);
                            echo $this->Form->input('Order.shipment_method_id', array('label' => false, 'type' => 'select', 'options' => $shipmentMethodOptionsShow, 'class' => "shipment-price"));
//                echo $this->Form->input('Order.shipment_method_id', array('label' => 'Sposób dostawy: ', 'type' => 'select', 'options' => $shipmentMethodOptionsShow, 'class' => "shipment-price"));
                            ?>
                            <?php echo $this->Form->hidden('Order.shipment_price', array('id' => 'shipmentPrice')); ?>
                        </div>
                        <div id="shipment_discount" class="dn" style="margin-left:70%"><?php echo __('Wartość przesyłki z rabatem'); ?>: <b><span id="shipment_discount_value" total=""></span></b></div>
                    </div>
                </div>
            </div>
            <div class="green-field padding20 clearfix">
                <div class="koszty-razem pull-right ">
                    <small><?php echo __('Razem do zapłaty'); ?>:</small> <big><span id="razem-z-wysylka"></span></big>
                </div>
            </div>
            <div class="border-page clearfix padding20">
                <div class="bottom-cart-nav pull-left">
                    <?php echo $this->Html->link(__('wróć do zakupów'), '/', array('class' => 'backToShop btnBlueWhite button black white-text disabled')); ?>
                </div>
                <div class="bottom-cart-nav pull-right">
                    <?php echo $this->Form->submit(__('Przejdź do zamówienia'), array('escape' => false, 'class' => 'pull-right')); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end(); ?>


<script>
    var gPromotionCodeValue = <?php echo empty($order['PromotionCode']['value']) ? 0 : $order['PromotionCode']['value']; ?>;
    var gCustomerDiscount = <?php echo empty($order['Customer']['discount']) ? 0 : $order['Customer']['discount']; ?>;
    var gShipmentMethods = <?php echo json_encode($shipmentMethods); ?>;
</script>

<script type="text/javascript">
//<![CDATA[
    /**
     * Funkcja sprawdza wprowadzany kod promocyjny
     */
    var onchangePromoCode = function() {
        $.ajax({
            url: '<?php echo $this->Html->url(array('controller' => 'orders', 'action' => 'promotion_code', $order['Order']['id'])); ?>',
            dataType: 'json',
            type: 'POST',
            data: {
                data: {
                    PromotionCode: {
                        code: $('#PromotionCodeCode').val()
                    }
                }
            },
            success: function(data) {
                if (data.promo_code_value == false) {
                    if ($('#PromotionCodeCode').val() != '') {
                        $('#PromotionCodeCode').css('border-color', 'red');
                        $('#promotion_code_delete').removeClass('dn');
                    } else {
                        $('#PromotionCodeCode').css('border-color', '');
                        $('#promotion_code_delete').addClass('dn');
                    }
                    $('#promotion_code_info').addClass('dn');
                } else {
                    gPromotionCodeValue = data.promo_code_value;
                    $('#PromotionCodeCode').css('border-color', '#25BA57');
                    $('#PromotionCodeCode').attr('disabled', true);
                    $('#promotion_code_delete').removeClass('dn');
                    $('#promotion_code_info').removeClass('dn');
                    $('#razem-bez-wysylki').css('text-decoration', 'line-through');


                    var price_before_promo = $('#razem-bez-wysylki').attr('total');
                    var bonus = price_before_promo - (price_before_promo * (gPromotionCodeValue / 100));
                    bonus = bonus.toFixed(2);
                    $('#price-after-promo').attr('bonus', parseFloat(bonus).toFixed(2));
                    var bonusText = bonus.toString().replace('.', ',') + ' ₴';
                    $('#price-after-promo').text(bonusText);

                    $('#activeCode').text(gPromotionCodeValue);
                    $('#PromotionCodeCodeId').attr('value', data.code_id);
                    updateTotalPrice();
                    update_minicart();
                }
            },
            error: function(o1, o2, o3, o4) {
            }
        });
    }

    $('#PromotionCodeCode').on('keyup', onchangePromoCode);
    $('#PromotionCodeCode').on('mouseup', onchangePromoCode);
//    $('#PromotionCodeDelete a').on('click', onchangePromoCode);
    $('#promotion_code_delete a').on('click', function() {
        $('*').css('cursor', 'wait');
        $('#PromotionCodeCode').val('');
        $('#PromotionCodeCode').attr('disabled', false);
        $('#PromotionCodeCode').css('border-color', '');
        onchangePromoCode();
        setTimeout(function() {
//        window.location.href = "<?php echo $this->Html->url(null, true); ?>";
            window.location.reload();
        }, 500);
    });

    $('input').click(updateCookie);
    $('option').click(updateCookie);
    $('a.button').click(updateCookie);

    function updateCookie() {
        $.ajax({
            url: '<?php echo $this->Html->url(array('admin' => false, 'plugin' => 'commerce', 'controller' => 'orders', 'action' => 'ajax_update_cookie_time')); ?>',
            dataType: 'html',
            type: 'post',
            data: {order_id: '<?php echo $order['Order']['id']; ?>'},
            success: function(data) {
            },
            error: function() {
            }
        });
    }
//]]>
</script>

<script type="text/javascript">
    function updateTotalPrice() {
        var shipments = <?php echo json_encode($shipmentMethods); ?>;
//        var selected = $('.shipment-price').select2("val");
        var selected = $('.shipment-price').val();
        var price = 0;
        for (key in shipments) {
            if (selected == shipments[key].ShipmentMethod.id) {
                price = shipments[key].ShipmentMethod.final_price_gross;
            }
        }
        updateCustomerDiscount();
        //updateShipmentDiscount();

        var shipmentDiscountValue = $('#shipment_discount_value').attr('total');
        if (shipmentDiscountValue) {
            price = parseFloat(shipmentDiscountValue);
        }

        if (gPromotionCodeValue) {
            if (gCustomerDiscount) {
                if (gPromotionCodeValue < gCustomerDiscount) {
                    $('#razem-bez-wysylki').css('text-decoration', 'line-through');
                    $('#price-after-promo').css('text-decoration', 'line-through');
                    var customerDiscountValueTotal = $('#customer_discount_value').attr('total');
                    var razemZWysylkaTotal = (price + parseFloat(customerDiscountValueTotal)).toFixed(2);
                    var razemZWysylka = razemZWysylkaTotal.toString().replace('.', ',') + ' ₴';
                    $('#razem-z-wysylka').attr('total', razemZWysylkaTotal);
                    $('#razem-z-wysylka').text(razemZWysylka);
                } else {
                    $('#razem-bez-wysylki').css('text-decoration', 'line-through');
                    $('#customer_discount_value').css('text-decoration', 'line-through');
                    var priceAfterPromoBonus = $('#price-after-promo').attr('bonus');
                    var razemZWysylkaTotal = (price + parseFloat(priceAfterPromoBonus)).toFixed(2);
                    var razemZWysylka = razemZWysylkaTotal.toString().replace('.', ',') + ' ₴';
                    $('#razem-z-wysylka').attr('total', razemZWysylkaTotal);
                    $('#razem-z-wysylka').text(razemZWysylka);
                }
            } else {
                $('#razem-bez-wysylki').css('text-decoration', 'line-through');
                var priceAfterPromoBonus = $('#price-after-promo').attr('bonus');
                var razemZWysylkaTotal = (price + parseFloat(priceAfterPromoBonus)).toFixed(2);
                var razemZWysylka = razemZWysylkaTotal.toString().replace('.', ',') + ' ₴';
                $('#razem-z-wysylka').attr('total', razemZWysylkaTotal);
                $('#razem-z-wysylka').text(razemZWysylka);
            }
        } else {
            if (gCustomerDiscount) {
                $('#razem-bez-wysylki').css('text-decoration', 'line-through');
                var customerDiscountValueTotal = $('#customer_discount_value').attr('total');
                var razemZWysylkaTotal = (price + parseFloat(customerDiscountValueTotal)).toFixed(2);
                var razemZWysylka = razemZWysylkaTotal.toString().replace('.', ',') + ' ₴';
                $('#razem-z-wysylka').attr('total', razemZWysylkaTotal);
                $('#razem-z-wysylka').text(razemZWysylka);
            } else {
                var razemBezWysylkiTotal = $('#razem-bez-wysylki').attr('total');
                var razemZWysylkaTotal = (price + parseFloat(razemBezWysylkiTotal)).toFixed(2);
                var razemZWysylka = razemZWysylkaTotal.toString().replace('.', ',') + ' ₴';
                $('#razem-z-wysylka').attr('total', razemZWysylkaTotal);
                $('#razem-z-wysylka').text(razemZWysylka);
            }
        }
    }
    /**
     * Funkcja aktualizuje rabat konsumenta
     */
    function updateCustomerDiscount() {
        if (gCustomerDiscount) {
            if (gPromotionCodeValue) {
                if (gCustomerDiscount >= gPromotionCodeValue) {
                    var razemBezWysylkiTotal = $('#razem-bez-wysylki').attr('total');
                    var customerDiscountValueTotal = razemBezWysylkiTotal - razemBezWysylkiTotal * (gCustomerDiscount / 100);
                    customerDiscountValueTotal = parseFloat(customerDiscountValueTotal).toFixed(2);
                    $('#customer_discount_value').attr('total', customerDiscountValueTotal);
                    var customerDiscountValue = customerDiscountValueTotal.toString().replace('.', ',') + ' ₴';
                    $('#customer_discount_value').text(customerDiscountValue);

                    var promotionCodeDiscoutValue = razemBezWysylkiTotal - razemBezWysylkiTotal * (gPromotionCodeValue / 100);
                    promotionCodeDiscoutValue = parseFloat(promotionCodeDiscoutValue).toFixed(2);
                    $('#price-after-promo').attr('total', promotionCodeDiscoutValue);
                    promotionCodeDiscoutValue = promotionCodeDiscoutValue.toString().replace('.', ',') + ' ₴';
                    $('#price-after-promo').text(promotionCodeDiscoutValue);
                } else {
                    var razemBezWysylkiTotal = $('#razem-bez-wysylki').attr('total');
                    var customerDiscountValueTotal = razemBezWysylkiTotal - razemBezWysylkiTotal * (gCustomerDiscount / 100);
                    customerDiscountValueTotal = parseFloat(customerDiscountValueTotal).toFixed(2);
                    $('#customer_discount_value').attr('total', customerDiscountValueTotal);
                    var customerDiscountValue = customerDiscountValueTotal.toString().replace('.', ',') + ' ₴';
                    $('#customer_discount_value').text(customerDiscountValue);
                }
            } else {
                var razemBezWysylkiTotal = $('#razem-bez-wysylki').attr('total');
                var customerDiscountValueTotal = razemBezWysylkiTotal - razemBezWysylkiTotal * (gCustomerDiscount / 100);
                customerDiscountValueTotal = parseFloat(customerDiscountValueTotal).toFixed(2);
                $('#customer_discount_value').attr('total', customerDiscountValueTotal);
                var customerDiscountValue = customerDiscountValueTotal.toString().replace('.', ',') + ' ₴';
                $('#customer_discount_value').text(customerDiscountValue);
            }
        }
    }
    /**
     * Funkcja aktualizuje cenę dostawy w zależności od rabatu
     */
    function updateShipmentDiscount() {
        var shipmentPriceId = $('#OrderShipmentMethodId option:selected').val();
        var shipmentMethodPriceGross = 0;
        for (x in gShipmentMethods) {
            if (shipmentPriceId == gShipmentMethods[x].ShipmentMethod.id) {
                shipmentMethodPriceGross = gShipmentMethods[x].ShipmentMethod.price_gross;
                break;
            }
        }
        if (parseFloat(shipmentMethodPriceGross)) {
            var promotionValue = 0;
            if (gPromotionCodeValue) {
                if (gCustomerDiscount) {
                    promotionValue = (gPromotionCodeValue >= gCustomerDiscount) ? gPromotionCodeValue : gCustomerDiscount;
                } else {
                    promotionValue = gCustomerDiscount;
                }
            } else {
                promotionValue = (gCustomerDiscount) ? gCustomerDiscount : 0;
            }
            if (promotionValue) {
                var shipmentDiscountValue = shipmentMethodPriceGross - shipmentMethodPriceGross * promotionValue / 100;
                setShipmentDiscount(shipmentDiscountValue);
            } else {
                shipmentDiscountValue(0);
            }
        } else {
            setShipmentDiscount(0);
        }
    }
    //updateShipmentDiscount();
    /**
     * Funkcja wyświetla wartości rabatu dla przesyłki
     */
    function setShipmentDiscount(shipmentDiscountPrice) {
        if (parseFloat(shipmentDiscountPrice)) {
            var shipmentDiscountPriceTotal = shipmentDiscountPrice.toFixed(2);
            $('#shipment_discount_value').attr('total', shipmentDiscountPriceTotal);
            var shipmentDiscountPrice = shipmentDiscountPriceTotal.toString().replace('.', ',') + ' ₴';
            $('#shipment_discount_value').text(shipmentDiscountPrice);
            $('#shipment_discount').removeClass('dn');
        } else {
            $('#shipment_discount_value').attr('total', 0);
            $('#shipment_discount_value').text('0');
            $('#shipment_discount').addClass('dn');
        }
    }

    function quantityUpdate(id, Lp_nr) {
        jQuery.ajax({
            url: '<?php echo $this->Html->url(array('action' => 'quantity')); ?>' + '/' + id,
            data: jQuery('#quantity' + id + ' input').serialize(),
            dataType: 'html',
            type: "POST",
            success: function(data) {
                jQuery('#quantity' + id).html(data);
                jQuery('#quantity' + id + " .itemIndex ").text(Lp_nr);
            }
        });
        setTimeout(updateCustomerDiscount, 800);
        //setTimeout(onchangePromoCode, 800);
        //setTimeout(updateTotalPrice, 800);
        //setTimeout(update_minicart, 800);

    }


    function update_minicart() {
        var product_count = 0;
        $('#big-cart tbody tr td input').each(function() {
            product_count = parseInt(product_count) + parseInt(this.value);
        });
        $('.products-count strong').empty();
        $('.products-count strong').text(product_count);
        var product_price = 0;

        if (gPromotionCodeValue) {
            if (gCustomerDiscount) {
                if (gPromotionCodeValue >= gCustomerDiscount) {
                    product_price = $('#price-after-promo').html();
                } else {
                    product_price = $('#customer_discount_value').html();
                }
            } else {
                product_price = $('#price-after-promo').html();
            }
        } else {
            if (gCustomerDiscount) {
                product_price = $('#customer_discount_value').html();
            } else {
                product_price = $('#razem-bez-wysylki').html();
            }
        }
        $('.products-total').html(product_price);
    }
</script>

<!-- Podstawowe ustawienia -->
<script>
    if (gPromotionCodeValue) {
        $('#promotion_code_insert').removeClass('dn');
        $('#promotion_code_delete').removeClass('dn');
        $('#promotion_code_info').removeClass('dn');
    } else {
        $('#promotion_code_insert').addClass('dn');
        $('#promotion_code_delete').addClass('dn');
        $('#promotion_code_info').addClass('dn');
    }
</script>

<script type="text/javascript">
    //<![CDATA[
    $('#OrderPromotionCode').change(function() {
        if ($('#OrderPromotionCode:checked').val() == 1) {
            $('#promotion_code_insert').removeClass('dn');
            //$('#promotion_code_info').removeClass('dn');
        } else {
            $('#promotion_code_insert').addClass('dn');
            //$('#promotion_code_info').addClass('dn');
            onchangePromoCode();
        }
        updateTotalPrice();
    });
    $('.shipment-price').on('change', function() {
        updateTotalPrice();
    });
    $(document).ready(function() {
//        $(".input.select select").select2({
//            minimumResultsForSearch: 50,
//            triggerChange: true
//        });
        onchangePromoCode();
        updateTotalPrice();
        update_minicart();
    });
    //]]>
    $(document).ready(function() {
        $(document).on("click", ".BigTab .belkajQ.strzalkaClose", function() {
            $(this).removeClass('strzalkaClose').addClass('strzalkaOpen');
        });
        $(document).on("click", ".BigTab .belkajQ.strzalkaOpen", function() {
            $(this).removeClass('strzalkaOpen').addClass('strzalkaClose');
        });
    });
</script>