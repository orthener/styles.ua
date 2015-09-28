<?php
//echo $this->FebHtml->meta('description','',array('inline'=>false));
//echo $this->FebHtml->meta('keywords','',array('inline'=>false));
$this->set('title_for_layout', __d('public', 'Podsumowanie'));
//echo $this->Html->script('jquery.valid8');
?>
<?php $this->Html->addCrumb(__('Strona główna'), '/'); ?>
<?php $this->Html->addCrumb(__('Koszyk'), array('plugin' => 'commerce', 'controller' => 'orders', 'action' => 'cart')); ?>
<?php $this->Html->addCrumb(__('Składanie zamówienia')); ?>
<?php echo $this->Form->create('Order'); ?>
<?php echo $this->Form->hidden('Order.id', array('value' => $order['Order']['id'])); ?>
<div id="cart" class="clearfix orders">
    <div class="row-fluid">
        <div class="breadcrump span12 bt-no-margin">
            <span class="navi"><?php echo __('NAVIGATION')?>:</span> <?php echo $this->Html->getCrumbList(array('class' => 'breadcrumb')); ?>
        </div>
    </div>
    <div class="white-background  clearfix">
        <div class="clearfix">
            <div class="cart-navi border-page row-fluid clearfix">
                <span>1. <?php echo __('Twój koszyk');?></span> <i class="icon-arrow-right"></i> <span class="active">2. <?php echo __('Składanie zamówienia');?></span> <i class="icon-arrow-right"></i> <span>3. <?php echo __('Podsumowanie zakupu');?></span>
            </div>
            <div class="border-page">
                <div class="orders configurations orderCheckout">
                    <div class="green-field padding20 white-text orderTitleCollapse titleConf" id="title1" >
                        <a class="title"><span>1</span> <?php echo __('Sposób zamówienia');?></a>
                    </div>
                    <div id="1" class="steps step1 padding20 clearfix">
                        <?php echo $this->element('Orders/step2'); ?>    
                    </div>
                    <div class="green-field padding20 white-text orderTitleCollapse titleConf" id="title2"> 
                        <a class="title"><span>2</span> <?php echo __('Dane do faktury');?></a>
                    </div>
                    <div id="2" class="steps step2 padding20 clearfix">
                        <?php echo $this->element('Orders/step3'); ?>
                        <?php echo $this->Html->link(__('Kontynuuj'), array(), array('onclick' => "show_step('3');", 'default' => false, 'class' => 'pull-right button black white-text')); ?>
                    </div>
                    <div class="green-field padding20 white-text orderTitleCollapse titleConf" id="title3">
                        <a class="title"><span>3</span> <?php echo __('Dane do wysyłki');?></span></a>
                    </div>
                    <div id="3" class="steps step3 padding20 clearfix">
                        <?php echo $this->element('Orders/step4'); ?>
                        <?php echo $this->Html->link(__('Kontynuuj'), array(), array('onclick' => "show_step('4');", 'default' => false, 'class' => 'pull-right button black white-text')); ?>
                    </div>
                    <div  class="green-field padding20 white-text orderTitleCollapse titleConf" id="title4">
                        <a class="title"><span>4</span> <?php echo __('Metoda płatności');?></a>
                    </div>
                    <div id="4" class="steps step4 padding20 clearfix">
                        <?php echo $this->element('Orders/step5'); ?>
                        <?php echo $this->Html->link(__('Kontynuuj'), array(), array('onclick' => "show_step('5');", 'default' => false, 'class' => 'pull-right button black white-text')); ?>
                    </div>
                    <div  class="green-field padding20 white-text orderTitleCollapse titleConf" id="title5">
                        <a class="title"><span>5</span> <?php echo __('Podsumowanie zamówienia');?></a>
                    </div>
                    <div id="5" class="padding20 steps step5 clearfix">
                        <?php echo $this->element('Orders/step1'); ?>
                        <?php echo $this->element('Orders/step7'); ?>
                    </div>
                </div>
                <div class="clearfix orderSummary">
                    <div class="clearfix ordersBottom">
                        <div class="summary-order pull-right">
                            <p class="sum"><?php echo __('Suma');?>: <span id="razem-bez-wysylki"></span></p>
                            <p class="shipment-cost"><?php echo __('Koszt przesyłki');?>: <span id="shipmentCost"></span></p>
                            <p class="summ bigSumm border-top"><?php echo __('Do zapłaty');?>: <span id="razem-z-wysylka"></span></p>
                        </div>
                    </div>
                    <div class="clearfix padding20">
                        <?php echo $this->Form->submit(__('Zamów'), array('id' => 'form_submit', 'div' => 'fr submit', 'class' => 'btnBlueWhite pull-right button black white-text')); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end(); ?>


<script type="text/javascript">
    var step = <?php echo json_encode($step); ?>;
    var max_step = 1;
    var cash_on_delivery_price = <?php echo!empty($order['ShipmentMethod']['cash_on_delivery_price']) ? $order['ShipmentMethod']['cash_on_delivery_price'] : 0; ?>;
    isUser = '<?php echo!empty($user) ? 1 : 0; ?>';
    if (isUser == 1) {
        $('#guest_email').attr('disabled', true);
    }
    $('#userError').hide();
    show_step('1');
    
    
//    $('.orderAddres .required input[type=text]').valid8('Pole nie może być puste');
    function show_step(fun_step) {
        if (fun_step == 1 && isUser == 1) {
            //                $('#step2Config').hide();
            //                $('#logged').show();
            fun_step = 2;
        }
        //            } else if(fun_step == 2 && isUser != 1) {
        //                $('#step2Config').show();
        //                $('#logged').hide();
        //            }
        if (fun_step == 2) {
            fun_step = checkUser();
        }
        if (fun_step >= 3) {
            fun_step = checkInvoice(fun_step);
        }
        if (fun_step == 3 && $('#OrderDaneDoWysylkiInneNizDoFaktury:checked').length) {
            $('#OrderDataForm').css('display', 'block');
        }
        
        if (fun_step >= 4 && $('#OrderDaneDoWysylkiInneNizDoFaktury:checked').length) {
        //if (fun_step >= 3 && $('#OrderDaneDoWysylkiInneNizDoFaktury:checked').length) {
            fun_step = checkAddress(fun_step);
        }
        if (fun_step == 5) {
            update();
            $('#form_submit').attr('disabled', false).removeClass('disabled');
            $('#title5').addClass('active');
        } else {
            $('#form_submit').attr('disabled', true).addClass('disabled');
        }
        if (fun_step > max_step) {
            max_step = fun_step;
        }
        step = fun_step;
        var prev_step = (fun_step - 1);
        var steps = $('.steps');
        steps.each(function() {
            if ($(this).attr('id') != fun_step) {
                $(this).hide();
            }
            var id = $(this).attr('id');
            if ($(this).attr('id') <= fun_step) {
                $(this).prev().addClass('active');
                var text = $('#title' + id).find('a').html();
                $('#title' + id).html("<a href='#' onclick='show_step(" + (id) + "); return false;'>" + text + "</a>");
            }
            if ($(this).attr('id') == 5) {
                $(this).addClass('active');
            }
        });
        $('#' + fun_step).show().prev('div').find('span').addClass('more');
    }

    $('#form_submit').click(function() {
        document.forms["OrderOrderCheckoutForm"].submit();
    });
    $('#OrderOrderCheckoutForm').submit(function(e) {
        e.preventDefault();
    });
    $('.orderPaySelect').mouseup(function(e) {
        setTimeout("updateTotalPrice()");
    });
    function update() {
        var txt_ImieINazwisko = "<?php echo __('Imię i nazwisko'); ?>";
        var txt_Adres = "<?php echo __('Adres'); ?>";
        if ($('#OrderDaneDoWysylkiInneNizDoFaktury:checked').length) {
            $('#sendAddress').text('');
            $('#sendAddress').append('<strong>' + txt_ImieINazwisko + ':</strong> ' + $('#AddressDefaultName').val() + '<br />');
            $('#sendAddress').append('<strong>' + txt_Adres + ':</strong> <br/>' + $('#AddressDefaultAddress').val() + ' ' + $('#AddressDefaultNr').val() + '/' + $('#AddressDefaultFlatNr').val() + '<br />');
            $('#sendAddress').append($('#AddressDefaultPostCode').val() + ' ' + $('#AddressDefaultCity').val() + '<br />');
            if( $('#AddressDefaultCountryId :selected').val() == "PL" ) {
                $('#sendAddress').append($('#AddressDefaultRegionId > option:selected').text() + ', ' + $('#AddressDefaultCountryId :selected').text());
            } else {
                $('#sendAddress').append($('#AddressDefaultCountryId :selected').text());
            }
        } else {
            $('#sendAddress').text('');
            $('#sendAddress').append('<strong>' + txt_ImieINazwisko + ':</strong> ' + $('#InvoiceIdentityDefaultName').val() + '<br />');
            $('#sendAddress').append('<strong>' + txt_Adres + ':</strong> <br/>' + $('#InvoiceIdentityDefaultAddress').val() + ' ' + $('#InvoiceIdentityDefaultNr').val() + '/' + $('#InvoiceIdentityDefaultFlatNr').val() + '<br />');
            $('#sendAddress').append($('#InvoiceIdentityDefaultPostCode').val() + ' ' + $('#InvoiceIdentityDefaultCity').val() + '<br />');
            if($('#InvoiceIdentityDefaultCountryId :selected').val() == "PL") {
                $('#sendAddress').append($('#InvoiceIdentityDefaultRegionId > option:selected').text() + ', ' + $('#InvoiceIdentityDefaultCountryId :selected').text());
            } else {
                $('#sendAddress').append($('#InvoiceIdentityDefaultCountryId :selected').text())
            }
        }
        $('#paymentMethod').text($('input[type="radio"]:checked.updatePrices').next('label').text());
        var payment_id = $('.orderPaySelect input:checked').attr('value');
        if (payment_id == 2) {
            //$('#cash_on_delivery_price_tr .itemPrice').html(FEB.currency_format(cash_on_delivery_price, 'PLN'));
//            $('#cash_on_delivery_price_tr .itemPriceFinal').html(FEB.currency_format(cash_on_delivery_price * 1.23, 'PLN'));
            $('#cash_on_delivery_price_tr .itemPriceFinal').html(FEB.currency_format(cash_on_delivery_price, ' ₴'));
            $('#cash_on_delivery_price_tr').show();
        } else {
            $('#cash_on_delivery_price_tr').hide();
        }
//        if (payment_id == 1 || payment_id == 4) {
//            $('#cost').text((parseFloat($('#razem-z-wysylka').text().replace(',', '.')) * 1.02).toFixed(2).replace('.', ','));
//        } else {
//            $('#cost').text($('#razem-z-wysylka').text());
//        }
        var paymentMethod = $('.orderPaySelect input:checked').next('label').html();
        $('#paymentMethod').html(paymentMethod);
    }

    function checkAddress(step) {
        var txt_PoprawDaneAdresowe = "<?php echo __('Popraw dane adresowe');?>";
        $('#addressError').text('').hide();
        if ($('#AddressDefaultName').val() === '' || $('#AddressDefaultCity').val() === '' || $('#AddressDefaultPostCode').val() === '' || $('#AddressDefaultAddress').val() === '') {
            $('#addressError').text(txt_PoprawDaneAdresowe).show();
            $(this).addClass('empty_warning');
            return 3;
        } else {
            return step;
        }
    }

    function checkInvoice(step) {
        var txt_PoprawDaneAdresowe = "<?php echo __('Popraw dane adresowe');?>";
        $('#ivoiceError').text('').hide();
        if ($('#InvoiceIdentityDefaultName').val() === '' || $('#InvoiceIdentityDefaultCity').val() === '' || $('#InvoiceIdentityDefaultPostCode').val() === '' || $('#InvoiceIdentityDefaultNr').val() === '') {
            $('#ivoiceError').text(txt_PoprawDaneAdresowe).show();
            return 2;
        } else {
            if (step > 3) {
                return step;
            }
            if ($('#OrderDaneDoWysylkiInneNizDoFaktury:checked').length) {
                return 3;
            } else {
                return 4;
            }
        }
    }

    function checkUser() {
        var txt_PodajPoprawnyAdresEmail = "<?php echo __('Podaj poprawny adres email'); ?>"
        var txt_ZalogujSie = "<?php echo __('Zaloguj się lub zamów jako gość akceptując warunki'); ?>";
        $('#userError').show();
        $('#userError').text('');
        if (isUser == 1) {
            return 2;
        } else if ( $('#guest_box:checked').length && $('#accept_box:checked').length ) {
            $('#guest_box').next('label').css('color', '#000');
            $('#accept_box').next('label').css('color', '#000');
            if (check_guest_email($('#guest_email').val())) {
                checkEmail($('#guest_email').val());
            } else {
                $('#userError').show();
                $('#userError').text(txt_PodajPoprawnyAdresEmail);
                return 1;
            }
        } else {
            $('#userError').show();
            $('#userError').text(txt_ZalogujSie);
            $('#guest_box').next('label').css('color', 'red');
            $('#accept_box').next('label').css('color', 'red');
            return 1;
        }
    }

    function check_guest_email(email) {
        return /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i.test(email);
    }

    function checkEmail(email) {
        var txt_PodanyAdresEmail = "<?php echo __('Podany adres email istnieje już w bazie danych'); ?>";
        var txt_WystapilBlad = "<?php echo __('Wystąpił błąd przy sprawdzaniu adresu. Spróbuj ponownie'); ?>";
        
        $.ajax({
            url: '<?php echo $this->Html->url(array('plugin' => 'commerce', 'controller' => 'customers', 'action' => 'check_email', 'ext' => 'json')); ?>',
            dataType: 'json',
            type: 'post',
            data: {data: email},
            success: function(json) {
                if (json.flag == false) {
                    $('#2').show();
                    $('#1').hide();
                    $('#guest_email').attr('readonly', 'readonly');
                    return 2;
                } else {
                    $('#userError').text(txt_PodanyAdresEmail);
                    $('#2').hide();
                    $('#1').show();
                    return 1;
                }
            },
            error: function() {
                $('#userError').text(txt_WystapilBlad);
                $('#2').hide();
                $('#1').show();
                return 1;
            }
        });
    }
        
    $('input[type="text"]').change(updateCookie);   
    $('a.button').click(updateCookie);     
        
    function updateCookie() {
        $.ajax({
            url: '<?php echo $this->Html->url(array('admin' => false, 'plugin' => 'commerce', 'controller' => 'orders', 'action' => 'ajax_update_cookie_time')); ?>',
            dataType: 'html',
            type: 'post',
            data: {order_id: '<?php echo $order['Order']['id'];?>'},
            success: function(data) {
            },
            error: function() {
            }
        });
    }

</script>
<!-- Aktualizacja mini koszyka -->
<script>
    function update_minicart() {
        var OrderId = '<?php echo $order['Order']['id']; ?>';
        /*jQuery.ajax({
            url: '<?php echo $this->Html->url(array('controller' => 'orders', 'action' => 'ajax_minicart_update')); ?>' + '/' + id,
            data: null,
            dataType: 'json',
            type: "POST",
            success: function(data) {
//                jQuery('#quantity' + id).html(data);
//                jQuery('#quantity' + id + " .itemIndex ").text(Lp_nr);
            }
        });*/
    }
    update_minicart();
</script>
<?php //debug($order); ?>
