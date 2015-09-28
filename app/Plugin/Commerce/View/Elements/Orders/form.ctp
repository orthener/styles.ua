<?php echo $this->Html->script('jquery-ui.min', array('inline' => false)); ?>
<div id="tab">
    <?php if (empty($myUser)) { ?>
        <ul>
            <li><?php echo $this->Html->link( __d('commerce', 'Nie masz konta? <span>Wprowadź dane.</span>'), '#dataform', array('escape'=>false)); ?></li>
            <li><?php echo $this->Html->link( __d('commerce', 'Masz już konto? <span>Zaloguj się!</span>'), '#userform', array('escape'=>false)) ?></li>
        </ul>
    <?php } ?>
    <div id="dataform">
        <?php echo $this->Form->create('Customer'); ?>
        <?php echo $this->Form->input('id'); ?>
        <fieldset>
            <h2><b><?php echo __('Dane do faktury'); ?></b></h2>
            <?php echo $this->Form->input('InvoiceIdentityDefault.iscompany', array('legend' => false, 'type' => 'radio', 'options' => array('zakupy prywatne', 'zakupy firmowe'), 'separator' => '</div><div class="radioType">','div'=>array('class'=>'radioType'))); ?>
            <div class="clearfix">
                <div class="treeBox">
                    <?php
                    echo $this->Form->input('InvoiceIdentityDefault.name', array('label' => __d('commerce', 'imię i nazwisko')));
                    echo $this->Form->input('InvoiceIdentityDefault.nip', array('label' => __d('commerce', 'NIP')));
                    echo $this->Form->input('InvoiceIdentityDefault.address', array('label' => __d('commerce', 'adres')));
                    ?>
                </div>
                <div class="treeBox">
                    <div class="postcode clearfix">
                        <?php
                        echo $this->Form->input('InvoiceIdentityDefault.post_code', array('label' => __d('commerce', 'kod pocztowy'), 'div' => array('class' => 'input text code')));
                        echo $this->Form->input('InvoiceIdentityDefault.city', array('label' => __d('commerce', 'miejscowość'), 'div' => array('class' => 'input text city')));
                        ?>
                    </div>
                    <?php
                    echo $this->Form->input('InvoiceIdentityDefault.country_id', array('label' => __d('commerce', 'kraj')));
                    echo $this->Form->input('InvoiceIdentityDefault.region_id', array('label' => __d('commerce', 'województwo'), 'empty' => 'województwo'));
                    ?>
                </div>
            </div>
            <?php echo $this->Form->input('dane_do_wysylki_inne_niz_do_faktury', array('type' => 'checkbox', 'label' => __d('commerce', 'Inne dane do wysyłki'))); ?>
        </fieldset>
        <fieldset class="clearfix" id="CustomerDataForm">
            <h2><b><?php echo __('Dane do wysyłki (jeśli inne niż do faktury)'); ?></b></h2>
            <div class="clearfix">
                <div class="treeBox"> 		
                    <?php
                    echo $this->Form->input('AddressDefault.name', array('label' => __d('commerce', 'imię i nazwisko lub nazwa')));
                    echo $this->Form->input('AddressDefault.address', array('label' => __d('commerce', 'adres')));
                    ?>
                </div>
                <div class="treeBox">
                    <div class="postcode clearfix">
                        <?php
                        echo $this->Form->input('AddressDefault.post_code', array('label' => __d('commerce', 'kod pocztowy'), 'div' => array('class' => 'input text code')));
                        echo $this->Form->input('AddressDefault.city', array('label' => __d('commerce', 'miejscowość'), 'div' => array('class' => 'input text city')));
                        ?>
                    </div>
                    <?php
                    echo $this->Form->input('AddressDefault.country_id', array('label' => __d('commerce', 'kraj')));
                    echo $this->Form->input('AddressDefault.region_id', array('label' => __d('commerce', 'województwo'), 'empty' => 'województwo'));
                    ?>
                </div>
            </div>
        </fieldset>
        <fieldset >
            <h2><b><?php echo __('Dane kontaktowe'); ?></b></h2>
            <div class="clearfix">
                <div class="treeBox">
                    <?php echo $this->Form->input('Customer.contact_person', array('label' => __d('commerce', 'imię i nazwisko'),'after'=>$this->Form->error('User.name'))); ?>  
                    <?php echo $this->Form->input('Customer.phone', array('label' => __d('commerce', 'telefon'))); ?>
                </div>
                <div class="treeBox">
                    <?php echo $this->Form->input('Customer.email', array('label' => __d('commerce', 'e-mail'),'after'=>$this->Form->error('User.email'))); ?>
                </div>
            </div>
            <?php if (empty($myUser)) { 
                echo $this->Form->input('register_me', array('type' => 'checkbox','div'=>array('id'=>'formRegisterMeInput', 'class' => 'input checkbox orangeProdukt', 'style' => 'padding:10px'), 'label' => __d('commerce', 'Chcę zapamiętać te dane do kolejnych zamówień i założyć konto.'))); ?>
                <span id="register_meMessage" class="error-message" style="text-align:left;">
                    Rezygnacja z konta w systemie będzie skutkować ograniczoną możliwością śledzenia zmian w realizacji zamówienia.</span>
            <?php } ?>
        </fieldset>

        <fieldset class="clearfix">
            <?php echo $this->Html->link('Wstecz', array('controller' => 'orders', 'action' => 'cart'), array('class' => 'blueButton fl')); ?>
            <?php echo $this->Form->submit('Dalej', array('class' => 'orangeButton fr', 'div' => false)); ?>
        </fieldset>

        <?php echo $this->Form->end(); ?>

    </div>
    <?php if (empty($myUser)) { ?>
        <div id="userform">
            <?php echo $this->Form->create('User', array('url' => array('controller'=>'users','action'=>'login','plugin'=>'user'), 'class' => 'clearfix widthCenter')); ?>
            <?php
            echo $this->Form->input('email', array('label' => __d('commerce', 'E-mail:')));
            echo $this->Form->input('pass', array('label' => __d('commerce', 'Hasło:'), 'type' => 'password'));
            echo $this->Form->hidden('from_shopping_step', array('value' => '1'));
            ?>
            <div class="clearfix userAction">
                <?php
                echo $this->Html->link('Przypomnij hasło', array('controller'=>'users','action'=>'pass_recall','plugin'=>false), array('class'=>'fr input checkbox'));
                echo $this->Form->input('remember', array('type' => 'checkbox', 'label' => __d('commerce', 'Zapamiętaj mnie'),'div'=>array('class'=>'fl checkbox') ));
                ?>
            </div>
            <?php
            echo $this->Form->submit('Zaloguj', array('class' => 'orangeButton'));
            echo $this->Form->end();
            ?>

        </div>
    <?php } ?>
    <script type="text/javascript">
        //label w inpucie
        jQuery('.city input[value=""], .city input:empty').click(function(){
            changeInput(jQuery(this));  
            hiddenInputLabel(jQuery(this)); 
        })
        jQuery('.city input[value=""], .city input:empty').focus(function(){
            changeInput(jQuery(this));  
            hiddenInputLabel(jQuery(this)); 
        })
        jQuery('.city input[value=""], .city input:empty').blur(function(){
            changeInput(jQuery(this));
        })
    	 
        changeInput();
    	
        function changeInput(){
            jQuery.each(
            jQuery('.city input'), function(index, value){  
                if(jQuery(value).val() != ''){
                    hiddenInputLabel(jQuery(value));
                }else{
                    showInputLabel(jQuery(value));
                }
            });
        }
    	
        function hiddenInputLabel(object){
            object.attr('title',object.prev('label').text()).prev('label').css('display','none');
        }
        function showInputLabel(object){
            object.prev('label').css('display','block');
        }
    	
        //wojewodztwo w zależności od kraju
        jQuery('#InvoiceIdentityDefaultCountryId, #AddressDefaultCountryId').change(function(){woj()});
        jQuery('#InvoiceIdentityDefaultCountryId, #AddressDefaultCountryId').blur(function(){ woj()});
        woj();
        
        function woj(){
            if(jQuery('#InvoiceIdentityDefaultCountryId').val() == 'PL'){
                jQuery('#InvoiceIdentityDefaultRegionId').parents('.input').css('display','block');
            }else{
                jQuery('#InvoiceIdentityDefaultRegionId').parents('.input').css('display','none');
            }
            if(jQuery('#AddressDefaultCountryId').val() == 'PL'){
                jQuery('#AddressDefaultRegionId').parents('.input').css('display','block');
            }else{
                jQuery('#AddressDefaultRegionId').parents('.input').css('display','none');
            }
        }
    	
        //dane do wysylki inne niz do faktury
        CustomerDaneDoWysylkiInneNizDoFaktury();
    	
        jQuery('#CustomerDaneDoWysylkiInneNizDoFaktury').change(function(){
            CustomerDaneDoWysylkiInneNizDoFaktury();
        })
    	
        function CustomerDaneDoWysylkiInneNizDoFaktury(){
            if(jQuery('#CustomerDaneDoWysylkiInneNizDoFaktury:checked').length){
                jQuery('#CustomerDataForm').show('fast');
            }else{
                jQuery('#CustomerDataForm').hide('fast');
            }
        }
    	
        //Prowadzę działalność gospodarczą
        InvoiceIdentityDefaultIscompany();
    	
        jQuery('input[name="data[InvoiceIdentityDefault][iscompany]"]').click(function(){
            InvoiceIdentityDefaultIscompany();
        })
    	
        function InvoiceIdentityDefaultIscompany(){
            if(parseFloat(jQuery('input[name="data[InvoiceIdentityDefault][iscompany]"]:checked').attr('value'))){
                jQuery('#InvoiceIdentityDefaultNip').parent('div').css('display','block');
                jQuery('#InvoiceIdentityDefaultName, #AddressDefaultName').prev('label').text('nazwa');
            }else{
                jQuery('#InvoiceIdentityDefaultNip').parent('div').css('display','none');
                jQuery('#InvoiceIdentityDefaultName, #AddressDefaultName').prev('label').text('imię i nazwisko');
            }
     	 
        }
        
        jQuery('#CustomerRegisterMe').change(function(){
            CustomerRegisterMe();
        })
    	
        function CustomerRegisterMe(){
            if(jQuery('#CustomerRegisterMe:checked').length){
                jQuery('#register_meMessage').css('display','none');
            }else{
                jQuery('#register_meMessage').css('display','block');
            }
        }
        CustomerRegisterMe();
        //navigacja
        jQuery('#tab').tabs();
    </script>
</div>