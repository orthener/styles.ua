<p id="userError"></p>
<div class="clearfix productsLogin">
    <div id="step2Config">
        <div>
            <div class="step1Chooser">
                <div id="loginNow"><?php echo __d('public', 'Posiadam konto, chce się zalogować'); ?></div>
            </div>
            <div class="step1Choose clearfix">
                <div id="loginNowTab" class="clearfix">
                    <div class="productsLoginLabel"><?php echo __d('public', 'Logowanie'); ?></div>
                    <?php
                    echo $this->Form->input('email', array('id' => 'login_l', 'label' => false, 'placeholder' => 'Email'));
                    echo $this->Form->input('pass', array('type' => 'password', 'id' => 'password_l', 'label' => false, 'placeholder' => 'Hasło'));
//        echo $this->Form->input('terms', array('type' => 'checkbox', 'label' => 'Pamiętaj mnie'));  
                    echo $this->Form->submit(__('Zaloguj'), array('id' => 'login_submit', 'class' => 'btnGradientBlue'));
                    ?>
                    <p id="login_info"></p>
                </div>
            </div>
        </div>
        <div>
            <div class="step1Chooser">
                <div id="registerNow"><?php echo __d('public', 'Założę konto podczas składania zamówienia'); ?></div>
            </div>
            <div class="step1Choose clearfix">
                <div id="registerNowTab" class="clearfix">
                    <div class="productsLoginLabel"><?php echo __d('public', 'Rejestracja'); ?></div>
                    <?php
                    echo $this->Form->input('email', array('id' => 'login_r', 'label' => false, 'placeholder' => __('Email')));
                    echo $this->Form->input('name', array('id' => 'name_r', 'label' => false, 'placeholder' => __('Login')));
                    echo $this->Form->input('terms', array('type' => 'checkbox', 'label' => $this->Html->link(__('Akceptuję'), array('plugin' => 'page', 'controller' => 'pages', 'action' => 'view', 'regulamin')) . ' ' .  __d('front', 'warunki'), 'id' => 'terms'));
                    echo $this->Form->submit(__('Rejestruj'), array('id' => 'register_submit', 'class' => 'btnGradientBlue'));
                    ?>
                    <p id="reg_info"></p>
                </div>
            </div>
        </div>
        <div>
            <div class="step1Chooser">
                <div id="withoutRegister"><?php echo __d('public', 'Chcę dokonać zakupu bez zakładania konta'); ?></div>
            </div>
            <div class="step1Choose clearfix">
                <div id="withoutRegisterTab" class="clearfix">
                    <div class="productsLoginTexts">
                        <?php echo __d('public', 'Możesz dokonać zakupów bez rejestracji'); ?>. <br />
                    </div>
                    <?php
                    $rules_link = $this->Html->link(__d('public', 'Regulaminem'), array('plugin'=>'page', 'controller' => 'pages', 'action' => 'view', 'regulamin'));
                    $privacy_policy_link = $this->Html->link(__d('public', 'Polityką prywatności'), array('plugin'=>'page', 'controller' => 'pages', 'action' => 'view', 'polityka-prywatnosci'));
                    $label = sprintf(__d('public', 'Oświadczam, że zapoznałem się z %s oraz %s, rozumiem je i zobowiązuję się je przestrzegać.'), $rules_link, $privacy_policy_link);
                    echo $this->Form->input('guest', array('type' => 'checkbox', 'id' => 'guest_box', 'label' => __d('front', 'Robię zakupy jako gość')));
                    echo $this->Form->input('accept', array('type' => 'checkbox', 'id' => 'accept_box', 'label' => $label));
                    echo $this->Form->input('guest_email', array('type' => 'text', 'id' => 'guest_email', 'placeholder' => 'Email', 'label' => false));
                    echo $this->Form->submit(__('Kontynuuj'), array('id' => 'guest_submit', 'onClick' => "show_step('2')", 'class' => 'btnGradientBlue'));
                    ?>

                </div>
            </div>
        </div>
    </div>
    <!--    <div id="logged">
            Jesteś już zalogowany!
            <div class="orderRedLink"><?php echo $this->Html->link(__('Przejdź dalej') . ' ›', array(), array('onclick' => "show_step('2');", 'default' => false, 'class' => 'btnGradientBlue')); ?></div>
        </div>-->
    <?php echo $this->Form->hidden('customer_id', array('id' => 'cust_input')); ?>
    <script type="text/javascript">
        $(document).ready(function() {
            $('label a[href]').click(function(e) {
                e.preventDefault();

                if (this.getAttribute('target') === '_blank') {
                    window.open(this.href, '_blank');
                } else {
                    window.open(this.href, '_blank');
                }
            });

            $('#loginNowTab').show();
            //        $('#loginNowTab').hide();
            $('#loginNow').addClass('active');
            $('#registerNowTab').hide();
            $('#withoutRegisterTab').hide();
            $('.step1Chooser > div').click(function() {
                $('.step1Chooser > div').removeClass('active');
                $(this).addClass('active');
                $('.step1Choose > div').hide();
                $('#' + $(this).attr('id') + 'Tab').show();
            });
            //        $('#registerNow').hide();
            //        $('#loginNow').hide();
        });
        $('#register_submit').bind('click', function() {
            var txt_TwojeKonto = "<?php echo __('Twoje konto zostało utworzone. Zostałeś automatycznie zalogowany'); ?>";
            var txt_SprawdzCzy = "<?php echo __('Sprawdź czy podałeś prawidłowe dane'); ?>";
            var txt_NieZaakceptowano = "<?php echo __('Nie zaakceptowano warunków'); ?>";
            var txt_NiePodano = "<?php echo __('Nie podano wszystkich danych'); ?>";
            $("#reg_info").text('');
            if ($('#login_r').val() != '' && $('#name_r').val() != '') {
                if ( $('input#terms:checked').length ) {
                    $.ajax({
                        url: '<?php echo $this->Html->url(array('plugin' => 'user', 'controller' => 'users', 'action' => 'register', 'ext' => 'json')); ?>',
                        dataType: 'json',
                        data: {email: $('#login_r').val(), name: $('#name_r').val()},
                        type: 'post',
                        success: function(json) {
                            if (json.status == 1) {
                                $("#reg_info").text(txt_TwojeKonto);
//                                $('#login_r').val('');
//                                $('#name_r').val('');
//                                $('#terms').attr('checked', false)
//                                $('#loginNowTab').show();
//                                $('#loginNow').addClass('active');
//                                $('#registerNow').removeClass('active');
//                                $('#registerNowTab').hide();
//                                $('#withoutRegisterTab').hide();
                                location.reload();
                            } else {
                                $("#reg_info").css("color", 'red').text(txt_SprawdzCzy);
                                if (json.errors != undefined) {
                                    if (json.errors.email != undefined) {
                                        $("#reg_info").append('<br />' + json.errors.email[0]);
                                    }
                                    if (json.errors.name != undefined) {
                                        $("#reg_info").append('<br />' + json.errors.name[0]);
                                    }
                                }
                            }
                        }
                    });
                } else {
                    $("#reg_info").stop().css("color", 'red').text(txt_NieZaakceptowano).fadeIn(800).fadeOut(2500);
                }
            } else {
                $("#reg_info").stop().css("color", 'red').text(txt_NiePodano).fadeIn(800).fadeOut(2500);
            }
        });

        $('#login_submit').bind('click', function() {
            var txt_NiePodano = "<?php echo __('Nie podano wszystkich danych'); ?>";
            $("#login_info").text('');
            if ($('#login_l').val() != '' && $('#password_l').val() != '') {
                $.ajax({
                    url: '<?php echo $this->Html->url(array('plugin' => 'user', 'controller' => 'users', 'action' => 'user_ajax_pass_check', 'ext' => 'json')); ?>',
                    dataType: 'json',
                    data: {User: {email: $('#login_l').val(), pass: $('#password_l').val()}},
                    type: 'post',
                    success: function(json) {
                        if (json.status == 1) {
                            window.location.href = '<?php echo $this->Html->url();?>';
                            $('#login_l').attr('disabled', true);
                            $('#password_l').attr('disabled', true);
                            $('#name_r').attr('disabled', true);
                            $('#login_r').attr('disabled', true);
                            isUser = 1;
                            $('#cust_input').val(json.user.Customer.id);
                            getAddress(json.user.Customer.id);
                            $('#guest_email').attr('disabled', true);
                            woj();
                            //show_step('2');
                        } else {
                            $('#login_info').css('color', 'red').text(json.notification.content);
                        }
                    }
                });

            } else {
                $("#login_info").stop().css("color", 'red').text(txt_NiePodano).fadeIn(800).fadeOut(2500);
            }
        });

        function getAddress(id) {
            //var id = 4;
            $.ajax({
                url: '<?php echo $this->Html->url(array('plugin' => 'commerce', 'controller' => 'orders', 'action' => 'get_user_address', 'ext' => 'json')); ?>',
                dataType: 'json',
                type: 'post',
                data: {id: id},
                success: function(json) {
                    $('#InvoiceIdentityDefaultName').attr('value', json.customer.InvoiceIdentityDefault.name);
                    $('#InvoiceIdentityDefaultAddress').attr('value', json.customer.InvoiceIdentityDefault.address);
                    $('#InvoiceIdentityDefaultCity').attr('value', json.customer.InvoiceIdentityDefault.city);
                    $('#InvoiceIdentityDefaultPostCode').attr('value', json.customer.InvoiceIdentityDefault.post_code);
                    $('#InvoiceIdentityDefaultCountryId').attr('value', json.customer.InvoiceIdentityDefault.country_id);
                    $('#InvoiceIdentityDefaultNip').attr('value', json.customer.InvoiceIdentityDefault.nip);
                    $('#InvoiceIdentityDefaultRegionId').attr('value', json.customer.InvoiceIdentityDefault.region_id);
                    
                    $('#InvoiceIdentityDefaultNr').attr('value', json.customer.InvoiceIdentityDefault.nr);
                    $('#InvoiceIdentityDefaultFlatNr').attr('value', json.customer.InvoiceIdentityDefault.flat_nr);
                    
                    $('#AddressDefaultName').attr('value', json.customer.AddressDefault.name);
                    $('#AddressDefaultAddress').attr('value', json.customer.AddressDefault.address);
                    $('#AddressDefaultCity').attr('value', json.customer.AddressDefault.city);
                    $('#AddressDefaultPostCode').attr('value', json.customer.AddressDefault.post_code);
                    $('#AddressDefaultCountryId').attr('value', json.customer.AddressDefault.country_id);
                    $('#AddressDefaultRegionId').attr('value', json.customer.AddressDefault.region_id);
                }
            });

        }

    </script>
</div>

<script type="text/javascript">
    //<![CDATA[
//    $(document).ready(function() {
//        $('input').iCheck({
//            checkboxClass: 'icheckbox_minimal',
//            radioClass: 'iradio_minimal'
//        });
//    });
    //]]>
</script>