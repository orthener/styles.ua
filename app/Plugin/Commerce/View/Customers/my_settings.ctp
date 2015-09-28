<?php $this->Html->addCrumb(__d('public', 'Strona główna'), '/'); ?>
<?php // $this->Html->addCrumb('Ustawienia konta', array('plugin' => 'commerce', 'controller' => 'customers', 'action' => 'my_orders_active'));  ?>
<?php $this->Html->addCrumb(__d('public', 'USTAWIENIA KONTA')); ?>

<?php $title = __d('public', 'USTAWIENIA KONTA'); ?>
<?php $this->set('title_for_layout', $title); ?>
<?php //debug($this->params['pass']); ?>
<div id="my-account" class="clearfix users">
    <div class="row-fluid">
        <div class="breadcrump span12 bt-no-margin">
            <span class="navi"><?php echo __d('front', 'NAVIGATION'); ?>:</span> <?php echo $this->Html->getCrumbList(array('class' => 'breadcrumb')); ?>
        </div>
    </div>
    <div class="white-background  clearfix">
        <div class="clearfix">
            <div class="border-page padding20">

                <h1><?php echo $title ?></h1>
                <?php
                /**
                 * #14309
                 * I guess it should be visible in both cases so we don't need
                 * to check if shop is disabled or not.
                 */
                ?>
                <?php // if (!Configure::read('Shop.disable')): ?>
                <div class="blueNav">
                    <?php echo $this->element('customer/menu'); ?>
                </div>
                <?php // endif; ?>

                <div id="my-account-content" class="orders">
                    <div class="">
                        <?php //debug($this->Html->); ?> 
                        <?php echo $this->Form->create('Customer', array('type' => 'file', 'url' => array('controller' => 'customers', 'action' => 'my_settings', $this->params['pass'][0]))); ?>
                        <?php echo $this->Form->input('id'); ?>
                        <?php if ($this->params['pass'][0] == 'login') { ?>
                            <fieldset>
                                <!--<h2><b><?php echo __('Nazwa konta'); ?></b></h2>-->
                                <?php echo $this->Form->input('User.id') ?>
                                <div class="treeBox relatywny">
                                    <?php
                                    echo $this->Form->input('User.email', array('label' => __d('front', 'adres e-mail'), 'value' => $customer['User']['email'], 'readonly' => true, 'style' => 'border: 0px none; '));
                                    ?>
                                    <span></span>
                                </div>
                                <div class="treeBox">
                                    <?php echo $this->Form->input('User.name', array('label' => __d('front', 'nazwa użytkownika'))); ?>
                                </div>
                            </fieldset>
                            <fieldset>
                                <h2><b><?php echo __d('front', 'Zmiana hasła'); ?></b></h2>
                                <div class="treeBox">
                                    <?php echo $this->Form->input('User.oldpass', array('label' => __d('front', 'aktualne hasło'), 'value' => '', 'type' => 'password')); ?>
                                </div>
                                <div class="treeBox">
                                    <?php echo $this->Form->input('User.newpass', array('label' => __d('front', 'nowe hasło'), 'value' => '', 'type' => 'password')); ?>
                                    <?php echo $this->Form->input('User.confirmpass', array('label' => __d('front', 'potwierdź hasło'), 'value' => '', 'type' => 'password')); ?>
                                </div>
                            </fieldset>
                            <fieldset>
                                <h2><b><?php echo __d('front', 'Edycja Avatara'); ?></b></h2>
                                <div class="avatarFile">
                                <?php  echo $this->FebForm->file('User.avatar', array('type' => 'file', 'label' => __d('front', 'Zdjęcie'))); ?>
                                </div>
                                <?php // echo $this->Form->input('User.avatar', array('type' => 'file', 'label' => false)); ?>
                                <?php // $imageOptions = array('width' => 100, 'height' => 100, 'x' => $customer['User']['x'], 'y' => $customer['User']['y']);?>
                                <?php // echo $this->Image->thumb('/files/user/' . $customer['User']['avatar'], $imageOptions, array('onclick' => 'editCrop();'), true); ?>
                                <?php echo $this->Jcrop->edit('User', 'avatar', $customer['User']['id']); ?>
                            </fieldset>

                        <?php } if ($this->params['pass'][0] == 'contact') { ?>
                            <fieldset>
                                <h2><b><?php echo __('Dane kontaktowe'); ?></b></h2>
                                <div class="treeBox">
                                    <?php echo $this->Form->input('Customer.contact_person', array('label' => __d('front', 'imię i nazwisko'))); ?>
                                    <?php echo $this->Form->input('Customer.email', array('label' => __d('front', 'e-mail kontaktowy'))); ?>
                                </div>
                                <div class="treeBox">
                                    <?php echo $this->Form->input('Customer.phone', array('label' => __d('front', 'telefon'))); ?>
                                </div>
                            </fieldset>
                            <fieldset class="" id="">
                                <h2><b><?php echo __('Dane do wysyłki'); ?></b></h2>
                                <?php //echo  $this->Form->input('AddressDefault.id') ?>
                                <div class="">
                                    <div class="treeBox"> 		
                                        <?php
                                        echo $this->Form->input('AddressDefault.name', array('label' => __d('front', 'imię i nazwisko lub nazwa')));
                                        echo $this->Form->input('AddressDefault.address', array('label' => __d('front', 'ulica')));
                                        echo $this->Form->input('AddressDefault.nr', array('label' => __d('front', 'nr domu')));
                                        echo $this->Form->input('AddressDefault.flat_nr', array('label' => __d('front', 'nr mieszkania')));
                                        echo $this->Form->input('AddressDefault.phone', array('label' => __d('front', 'telefon')));
                                        ?>
                                    </div>
                                    <div class="treeBox">
                                        <div class="postcode clearfix">
                                            <?php
                                            echo $this->Form->input('AddressDefault.post_code', array('label' => __d('front', 'kod pocztowy'), 'div' => array('class' => 'input text code')));
                                            echo $this->Form->input('AddressDefault.city', array('label' => __d('front', 'miasto'), 'div' => array('class' => 'input text city')));
                                            ?>
                                        </div>
                                        <?php
                                    //    echo $this->Form->input('AddressDefault.region_id', array('label' => __d('front', 'województwo'), 'empty' => __d('front', 'województwo')));
                                        ?>
                                    </div>
                                </div>
                            </fieldset>
                        <?php } else if ($this->params['pass'][0] == 'invoice') { ?>
                            <fieldset>
                                <h2><b><?php echo __('Dane do faktury'); ?></b></h2>
                                <?php //echo  $this->Form->input('InvoiceIdentityDefault.id') ?>
                                <?php echo $this->Form->input('InvoiceIdentityDefault.iscompany', array('legend' => false, 'type' => 'radio', 'options' => array(__d('front', 'zakupy prywatne'), __d('front', 'zakupy firmowe')), 'separator' => '')); ?>
                                <div class="clearfix">
                                    <div class="treeBox">
                                        <?php
                                        echo $this->Form->input('InvoiceIdentityDefault.name', array('label' => __d('front', 'imię i nazwisko lub nazwa')));
                                        echo $this->Form->input('InvoiceIdentityDefault.nip', array('label' => __d('front', 'NIP')));
                                        echo $this->Form->input('InvoiceIdentityDefault.address', array('label' => __d('front', 'ulica')));
                                        echo $this->Form->input('InvoiceIdentityDefault.nr', array('label' => __d('front', 'nr domu')));
                                        echo $this->Form->input('InvoiceIdentityDefault.flat_nr', array('label' => __d('front', 'nr mieszkania')));
                                        ?>
                                    </div>
                                    <div class="treeBox">
                                        <div class="postcode clearfix">
                                            <?php
                                            echo $this->Form->input('InvoiceIdentityDefault.post_code', array('label' => __d('front', 'kod pocztowy'), 'div' => array('class' => 'input text code')));
                                            echo $this->Form->input('InvoiceIdentityDefault.city', array('label' => false, 'div' => array('class' => 'input text city')));
                                            ?>
                                        </div>
                                        <?php
                                        echo $this->Form->input('InvoiceIdentityDefault.country_id', array('label' => __d('front', 'kraj'), 'default' => 'UA'));
                                        echo $this->Form->input('InvoiceIdentityDefault.region_id', array('label' => __d('front', 'województwo'), 'empty' => __d('front', 'województwo')));
                                        ?>
                                    </div>
                                </div>
                            </fieldset>
                        <?php } ?>
                        <fieldset>
                            <?php echo $this->Form->submit(__d('front', 'Zapisz'), array('class' => 'orangeButton fr')); ?>
                        </fieldset>
                        <?php echo $this->Form->end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    //wojewodztwo w zależności od kraju
    jQuery('#InvoiceIdentityDefaultCountryId, #AddressDefaultCountryId').change(function() {
        woj()
    });
    jQuery('#InvoiceIdentityDefaultCountryId, #AddressDefaultCountryId').blur(function() {
        woj()
    });
    woj();

    function woj() {
        if (jQuery('#InvoiceIdentityDefaultCountryId').val() == 'PL') {
            jQuery('#InvoiceIdentityDefaultRegionId').parents('.input').css('display', 'block');
        } else {
            jQuery('#InvoiceIdentityDefaultRegionId').parents('.input').css('display', 'none');
        }
        if (jQuery('#AddressDefaultCountryId').val() == 'PL') {
            jQuery('#AddressDefaultRegionId').parents('.input').css('display', 'block');
        } else {
            jQuery('#AddressDefaultRegionId').parents('.input').css('display', 'none');
        }
    }

    //dane do wysylki inne niz do faktury
    CustomerDaneDoWysylkiInneNizDoFaktury();

    jQuery('#CustomerDaneDoWysylkiInneNizDoFaktury').parent('div').click(function() {
        CustomerDaneDoWysylkiInneNizDoFaktury();
    })

    function CustomerDaneDoWysylkiInneNizDoFaktury() {
        if (jQuery('#CustomerDaneDoWysylkiInneNizDoFaktury:checked').length) {
            jQuery('#CustomerDataForm').css('display', 'block');
        } else {
            jQuery('#CustomerDataForm').css('display', 'none');
        }
    }

    //Prowadzę działalność gospodarczą
    InvoiceIdentityDefaultIscompany();
    jQuery('input[name="data[InvoiceIdentityDefault][iscompany]"]').on('change', function() {
        InvoiceIdentityDefaultIscompany();
    });

    function InvoiceIdentityDefaultIscompany() {
        if (parseFloat(jQuery('input[name="data[InvoiceIdentityDefault][iscompany]"]:checked').attr('value'))) {
            $('#InvoiceIdentityDefaultIscompany1').attr('checked', 'checked');
            jQuery('#InvoiceIdentityDefaultNip').parent('div').css('display', 'block');
        } else {
            $('#InvoiceIdentityDefaultIscompany0').attr('checked', 'checked');
//            $('#InvoiceIdentityDefaultIscompany0').iCheck('check');
            jQuery('#InvoiceIdentityDefaultNip').parent('div').css('display', 'none');
        }

    }
</script>
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