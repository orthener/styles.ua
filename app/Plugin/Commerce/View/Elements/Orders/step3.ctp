<p id="ivoiceError"></p>
<div class="orderAddres clearfix">
    <div>
        <div class="iscompany clearfix">
            <?php echo $this->Form->input('InvoiceIdentityDefault.iscompany', array('legend' => false, 'type' => 'radio', 'options' => array(__('zakupy prywatne'), __('zakupy firmowe')), 'separator' => '</div><div class="radioType">', 'div' => array('class' => 'radioType'))); ?>
        </div>
        <div class="clearfix">
            <?php
            echo $this->Form->input('InvoiceIdentityDefault.name', array('label' => __d('commerce', 'imię i nazwisko')));
            echo $this->Form->input('InvoiceIdentityDefault.nip', array('label' => __d('commerce', 'NIP')));
            echo $this->Form->input('InvoiceIdentityDefault.address', array('label' => __d('commerce', 'ulica')));
            echo $this->Form->input('InvoiceIdentityDefault.nr', array('label' => __d('commerce', 'nr domu')));
            echo $this->Form->input('InvoiceIdentityDefault.flat_nr', array('label' => __d('commerce', 'nr mieszkania')));
            echo $this->Form->input('InvoiceIdentityDefault.post_code', array('label' => __d('commerce', 'kod pocztowy'), 'div' => array('class' => 'input text code')));
            echo $this->Form->input('InvoiceIdentityDefault.city', array('label' => __d('front', 'miejscowość'), 'div' => array('class' => 'input text city')));
       //     echo $this->Form->input('InvoiceIdentityDefault.region_id', array('label' => __d('commerce', 'województwo'), 'empty' => 'województwo'));
            ?>
        </div>
        <div class="clearfix ">
            <?php // @isinfo - sprawdzić czy linijka poniżej jest potrzebna ?>
            <?php echo $this->Form->input('dane_do_wysylki_inne_niz_do_faktury', array('type' => 'checkbox', 'label' => __d('commerce', 'Dostawa pod inny adres'))); ?>
        </div>
    </div>
    <!--<div>-->
    <!--</div>-->
</div>
<script type="text/javascript">
//    $(document).ready(function() {
        
//    });
    // wojewodztwo w zależności od kraju
    jQuery('#InvoiceIdentityDefaultCountryId').change(function() {
        woj()
    });
    jQuery('#InvoiceIdentityDefaultCountryId').blur(function() {
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

    jQuery('#OrderDaneDoWysylkiInneNizDoFaktury').change(function() {
        CustomerDaneDoWysylkiInneNizDoFaktury();
    })

    function CustomerDaneDoWysylkiInneNizDoFaktury() {
        if (jQuery('#OrderDaneDoWysylkiInneNizDoFaktury').attr('checked')) {
            jQuery('#OrderDataForm').show('fast');
        } else {
            jQuery('#OrderDataForm').hide();
        }
    }

    //    CustomerDaneDoWysylkiInneNizDoFaktury();
    //Prowadzę działalność gospodarczą
    InvoiceIdentityDefaultIscompany();
    $('#ivoiceError').hide();
    jQuery('input[name="data[InvoiceIdentityDefault][iscompany]"]').on('change', function() {
        InvoiceIdentityDefaultIscompany();
    });

    function InvoiceIdentityDefaultIscompany() {
        if (parseFloat(jQuery('input[name="data[InvoiceIdentityDefault][iscompany]"]:checked').attr('value'))) {
//            $('#InvoiceIdentityDefaultIscompany1').iCheck('check');
            $('#InvoiceIdentityDefaultIscompany1').attr('checked',true);
            jQuery('#InvoiceIdentityDefaultNip').parent('div').css('display', 'block');
            jQuery('#InvoiceIdentityDefaultName, #AddressDefaultName').prev('label').text('<?php echo __d('front', 'nazwa'); ?>');
        } else {
//            $('#InvoiceIdentityDefaultIscompany0').iCheck('check');
            $('#InvoiceIdentityDefaultIscompany0').attr('checked',true);
            jQuery('#InvoiceIdentityDefaultNip').parent('div').css('display', 'none');
            jQuery('#InvoiceIdentityDefaultName, #AddressDefaultName').prev('label').text('<?php echo __d('commerce', 'imię i nazwisko'); ?>');
        }
    }
</script>