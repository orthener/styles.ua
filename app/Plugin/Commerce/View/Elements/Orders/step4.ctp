<p id="addressError"></p>
<div class="orderAddres clearfix">
    <div>        
        <div id="OrderDataForm">
            <h2><b><?php echo __('Dane do wysyłki'); ?></b></h2>
            <div class="clearfix">
                <div class="treeBox"> 		
                    <?php
                    echo $this->Form->input('AddressDefault.name', array('label' => __d('commerce', 'imię i nazwisko lub nazwa')));
                    echo $this->Form->input('AddressDefault.address', array('label' => __d('commerce', 'ulica')));
                    echo $this->Form->input('AddressDefault.nr', array('label' => __d('commerce', 'nr domu')));
                    echo $this->Form->input('AddressDefault.flat_nr', array('label' => __d('commerce', 'nr mieszkania')));
                    ?>
                    <?php
                    echo $this->Form->input('AddressDefault.post_code', array('label' => __d('commerce', 'kod pocztowy'), 'div' => array('class' => 'input text code')));
                    echo $this->Form->input('AddressDefault.city', array('label' => __d('front', 'miejscowość'), 'div' => array('class' => 'input text city')));
                    ?>
                    <?php
                 //   echo $this->Form->input('AddressDefault.region_id', array('label' => __d('commerce', 'województwo'), 'empty' => 'województwo'));
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

//     wojewodztwo w zależności od kraju
    jQuery('#AddressDefaultCountryId').change(function() {
        woj()
    });
    jQuery('#AddressDefaultCountryId').blur(function() {
        woj()
    });
    woj();
    $('#addressError').text('').hide();
//    function woj(){
//        if(jQuery('#InvoiceIdentityDefaultCountryId').val() == 'PL'){
//            jQuery('#InvoiceIdentityDefaultRegionId').parents('.input').css('display','block');
//        }else{
//            jQuery('#InvoiceIdentityDefaultRegionId').parents('.input').css('display','none');
//        }
//        if(jQuery('#AddressDefaultCountryId').val() == 'PL'){
//            jQuery('#AddressDefaultRegionId').parents('.input').css('display','block');
//        }else{
//            jQuery('#AddressDefaultRegionId').parents('.input').css('display','none');
//        }
//    }


    //dane do wysylki inne niz do faktury

    //    jQuery('#OrderDaneDoWysylkiInneNizDoFaktury').change(function(){
    //        CustomerDaneDoWysylkiInneNizDoFaktury();
    //    })
    //    	
    //    function CustomerDaneDoWysylkiInneNizDoFaktury(){
    //        if(jQuery('#OrderDaneDoWysylkiInneNizDoFaktury').attr('checked')){
    //            jQuery('#OrderDataForm').show('fast');
    //        }else{
    //            jQuery('#OrderDataForm').hide();
    //        }
    //    }
    //    	
    //    CustomerDaneDoWysylkiInneNizDoFaktury();
    //    //Prowadzę działalność gospodarczą
    //    InvoiceIdentityDefaultIscompany();
    //    	
    //    jQuery('input[name="data[InvoiceIdentityDefault][iscompany]"]').click(function(){
    //        InvoiceIdentityDefaultIscompany();
    //    })
    //    	
    //    function InvoiceIdentityDefaultIscompany(){
    //        if(parseFloat(jQuery('input[name="data[InvoiceIdentityDefault][iscompany]"]:checked').attr('value'))){
    //            jQuery('#InvoiceIdentityDefaultNip').parent('div').css('display','block');
    //            jQuery('#InvoiceIdentityDefaultName, #AddressDefaultName').prev('label').text('nazwa');
    //        }else{
    //            jQuery('#InvoiceIdentityDefaultNip').parent('div').css('display','none');
    //            jQuery('#InvoiceIdentityDefaultName, #AddressDefaultName').prev('label').text('imię i nazwisko');
    //        }
    //     	 
    //    }        
</script>