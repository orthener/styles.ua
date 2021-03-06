<?php $this->set('title_for_layout', __d('cms', 'Orders'));?>
<div class="buttonOrange">
    <?php
    $configure = array(
        'user_plugin' => 'Commerce',
        'user_model' => 'Customer',
        'user_row_id' => $order['Order']['customer_id'],
        'related_plugin' => 'Commerce',
        'related_model' => 'Order',
        'related_row_id' => $order['Order']['id']
    );
    //debug($configure);
    echo $this->element('Payments.button', array('configure' => $configure));
    ?>

 

    <?php
//    echo ' | '; 
//    if (empty($order['Invoice']['id'])) {
//        echo $this->Html->link('Wystaw fakturę', array('action' => 'create_invoice', $order['Order']['id']), array('class' => 'button'));
//    } else {
//        echo $this->Html->link('Pobierz fakturę', array('prefix' => 'admin', 'admin' => 'admin', 'plugin' => 'payments', 'controller' => 'invoices', 'action' => 'getpdf', $order['Invoice']['id']), array('class' => 'button'));
//    }
    ?>
    <?php echo $this->Html->link(__d('cms', 'Wyślij Wiadomość Email do Klienta'), array('action' => 'send_order_email', $order['Order']['id']), array('class' => 'button')); ?>
</div> 
<br /><br />   
<?php // echo $this->Html->script('jquery-ui.min', array('inline' => false)); ?>
<?php // echo $this->Html->script('jquery-ui-1.8.9.custom.min', array('inline' => true)); ?>
<?php echo $this->Html->script('/commerce/js/jquery.jeditable', array('inline' => false)); ?>
<?php echo $this->Html->script('/commerce/js/commerce', array('inline' => false)); ?>

<?php //echo $this->Html->css('ui-lightness/jquery-ui-1.8.14.custom'); ?>

<script type="text/javascript">
    var myThis = {};

    
    $(function(){
        var data = {};
        
        $('#OrderOrderStatusId').change(changeStatusFunc);
        
        changeStatusFunc();
        
        data = <?php echo json_encode($this->request->data) ?>;
        $('.note-mod').click(function(){
            $(this).parent().parent().next().click();
            return false;
        });
        $('.note-content').editable(function(value, settings) {
            var object = $(this);
            var toSend = {
                data: {
                    Note: {
                        id: $(this).attr('noteid'),
                        content: value
                    }
                }
            };
            changeOrder('<?php echo $this->Html->url(array('controller' => 'notes', 'action' => 'edit')) ?>', toSend, object)
            return value;
        }, {  
            height: '100px',
            type     : 'textarea',
            submit   : 'OK'
        });
    });
    
    var changeStatusFunc = function() {
        if ($('#OrderOrderStatusId').attr('value') == 50) {
            $('#OrderTrackNumber').parent('div').show();
        } else {
            $('#OrderTrackNumber').parent('div').hide();
        }
    }
    

</script>

<div id="editOrder" class="orders form">
    <?php
    echo $this->Form->create('Order');
    echo $this->Form->input('id');
    ?>
    <fieldset id="order-area">        
        <legend><?php echo __d('cms', 'Zamówienie Numer'); ?>: <b><?php echo $this->request->data['Order']['hash']; ?></b></legend>
        <b><?php echo __d('cms', 'Data utworzenia zamówienia'); ?>:</b> <?php echo $this->FebTime->niceShort($this->request->data['Order']['created']); ?><br/>
        <b><?php echo __d('cms', 'Ostatnia modyfikacja'); ?>:</b> <?php echo $this->FebTime->niceShort($this->request->data['Order']['modified']); ?><br/><br/>

        <table id="order-table" class="noBorder">
            <tr>
                <td>
                    <fieldset id="customer-contact">
                        <legend><?php echo __d('cms', 'Dane Klienta'); ?></legend>
                        <?php echo $this->Form->input('Customer.id', array('readonly' => true)); ?>
                        <?php echo $this->Form->input('Customer.contact_person', array('readonly' => true, 'label' => __('Nazwa'), 'type' => 'text')); ?>
                        <?php echo $this->Form->input('Customer.email', array('readonly' => true, 'label' => __('Email'), 'type' => 'text')); ?>
                        <?php echo $this->Form->input('Customer.phone', array('readonly' => true, 'label' => __('Telefon'), 'type' => 'text')); ?>
                        <div class="clearfix buttonOrange">
                            <?php echo $this->Html->link(__d('cms', 'Edycja Danych Klienta'), array('controller' => 'customers', 'action' => 'edit', $this->request->data['Customer']['id']), array('class'=>'fr')); ?>
                        </div>
                        
                    </fieldset>
                </td>
                <td>
                    <fieldset>
                        <legend><?php echo __d('cms', 'Status'); ?></legend>
                        
                        <?php echo $this->Form->input('order_status_id', array('label' => __d('cms', 'Status'))); ?>  
                        <?php echo $this->Form->input('track_number', array('label' => __d('cms', 'Nr listu przewozowego'))); ?>  
                        <?php echo $this->Form->input('vat', array('label' => __d('cms', 'Wystawiona faktura vat'), 'type' => 'checkbox')); ?>  
                    </fieldset>
                </td>
            </tr>
            <tr>
                <td>
                    <fieldset id="shipment-metod">
                        <legend><?php echo __d('cms', 'Dane do Wysyłki'); ?></legend>
                        <?php //debug($countries); ?>
                        <?php echo $this->Form->input('Order.address.name', array('label' => __('Imię i Nazwisko'), 'type' => 'text')); ?>
                        <?php echo $this->Form->input('Order.address.address', array('label' => __('Adres'), 'type' => 'text')); ?>
                        <?php echo $this->Form->input('Order.address.nr', array('label' => __('Nr domu'), 'type' => 'text')); ?>
                        <?php echo $this->Form->input('Order.address.flat_nr', array('label' => __('Nr mieszk.'), 'type' => 'text')); ?>
                        <?php echo $this->Form->input('Order.address.city', array('label' => __('Poczta'), 'type' => 'text')); ?>
                        <?php echo $this->Form->input('Order.address.post_code', array('label' => __('Kod Pocztowy'), 'type' => 'text')); ?>
                        <?php // echo $this->Form->input('Order.address.country_id', array('label' => __('Kraj'), 'options' => $countries)); ?>    
                        <?php // echo $this->Form->input('Order.address.region_id', array('label' => __('Województwo'), 'options' => $regions)); ?>                    
                    </fieldset>
                </td>
                <td rowspan="1">
                    <fieldset id="invoice-identities">
                        <legend><?php echo __d('cms', 'Dane do Faktury'); ?></legend>
                        <?php echo $this->Form->input('Order.invoice_identity.iscompany', array('label' => __('Firma'), 'type' => 'checkbox')); ?>
                        <?php echo $this->Form->input('Order.invoice_identity.name', array('label' => __('Nazwa'), 'type' => 'text')); ?>
                        <?php echo $this->Form->input('Order.invoice_identity.address', array('label' => __('Adres'), 'type' => 'text')); ?>
                        <?php echo $this->Form->input('Order.invoice_identity.nr', array('label' => __('Nr domu'), 'type' => 'text')); ?>
                        <?php echo $this->Form->input('Order.invoice_identity.flat_nr', array('label' => __('Nr mieszk.'), 'type' => 'text')); ?>
                        <?php echo $this->Form->input('Order.invoice_identity.nip', array('label' => __('NIP'), 'type' => 'text')); ?>
                        <?php echo $this->Form->input('Order.invoice_identity.city', array('label' => __('Poczta'), 'type' => 'text')); ?>
                        <?php echo $this->Form->input('Order.invoice_identity.post_code', array('label' => __('Kod Pocztowy'), 'type' => 'text')); ?>

                        <?php // echo $this->Form->input('Order.invoice_identity.country_id', array('label' => __('Kraj'), 'options' => $countries)); ?>
                        <?php // echo $this->Form->input('Order.invoice_identity.region_id', array('label' => __('Województwo'), 'options' => $regions)); ?>
                        <?php //echo $this->Form->button("Generuj Fakturę", array('onclick' => 'return false;'));  ?>
                    </fieldset>
                </td>
            </tr>
        </table>

        <div id="orders-items"><?php echo $this->element('Orders/admin_order_items', array('plugin' => 'commerce', 'orderItems' => $this->request->data['OrderItem'], 'order' => $this->request->data['Order'])); ?></div>
        <div id="orders-payments"><?php echo $this->element('Orders/admin_payments', array('plugin' => 'commerce', 'payments' => $this->request->data['Payment'])); ?></div>

        <fieldset id="notes">
            <legend><?php echo __d('cms', 'Notatki'); ?></legend>
            <?php // echo $this->Html->image('addnote.png', array('url' => '#', 'onclick'=> '$("#new-notes").show(); return false;', 'class' => 'addnote-button', 'title' => 'Dodaj nową notatkę')); ?>  
            <?php
            echo $this->Form->hidden('Note.row_id', array('value' => $this->request->data['Order']['id']));
            echo $this->Form->hidden('Note.model', array('value' => 'Order'));
            echo $this->FebTinyMce4->input('Note.content', array('label' => false, 'name' => 'data[Note][content]', 'id' => 'NoteContent'), 'full', array('width' => 718));
            ?>
            <div id="notes-area">
                <?php echo $this->element('Notes/notes', array('plugin' => 'commerce', 'notes' => $this->request->data['Note'])); ?>  
            </div>
        </fieldset>
        <?php //debug($diffs) ?>
        <div id="order-modyfications">
            <?php echo $this->element('Orders/modyfication', array('plugin' => 'commerce', 'diffs' => $diffs, 'orderStatuses' => $orderStatuses, 'shipmentMethods' => $shipmentMethods, 'regions' => $regions, 'countries' => $countries)); ?>
        </div>
        <?php
//        echo $this->Form->input('total');
//        echo $this->Form->input('total_tax_value');
        ?>
    </fieldset>
    <?php echo $this->Form->submit(__('Zapisz i wyślij wiadomość email do klienta'), array('name' => 'data[save_end_send]', 'div' => array('style' => 'float: left'), 'style' => 'display: inline')); ?>
    <?php echo $this->Form->submit(__('Zapisz'), array('name' => 'data[save_end_not_send]', 'style' => 'display: inline','id' => "wyrozniony", 'div' => array('style' => 'float: left'))); ?>
    <?php echo $this->Form->end(); ?>


</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <li><?php echo $this->Html->link(__('Lista Zamówień'), array('action' => 'index')); ?></li>
    </ul>
</div>
<script type="text/javascript">
    //wojewodztwo w zależności od kraju
    jQuery('#OrderInvoiceIdentityCountryId, #OrderAddressCountryId').change(function(){woj()});
    jQuery('#OrderInvoiceIdentityCountryId, #OrderAddressCountryId').blur(function(){ woj()});
    woj();
        
    function woj(){
        if(jQuery('#OrderInvoiceIdentityCountryId').attr('value') == 'PL'){
            jQuery('#OrderInvoiceIdentityRegionId').parents('.input').css('display','block');
        }else{
            jQuery('#OrderInvoiceIdentityRegionId').parents('.input').css('display','none');
        }
        if(jQuery('#OrderAddressCountryId').attr('value') == 'PL'){
            jQuery('#OrderAddressRegionId').parents('.input').css('display','block');
        }else{
            jQuery('#OrderAddressRegionId').parents('.input').css('display','none');
        }
    }
</script>