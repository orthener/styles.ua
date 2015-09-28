<a href="#" onclick="selectAll('selectOrderId'); return false;"><?php echo __d('public', 'Zaznacz/odznacz wszystkie'); ?></a>    
<script type="text/javascript">
//<![CDATA[
    selectAll = function(cssClass){
        if($('.' + cssClass + ':checked').length === $('.' + cssClass).length){
            $('.' + cssClass).attr('checked', null);
        } else {
            $('.' + cssClass).attr('checked', 'checked');
        }
    }
    getSelected = function(cssClass){
        var selectedOrderIds = new Array;
        $('.' + cssClass + ':checked').each(function(){
            selectedOrderIds.push(this.value);
        });
        return selectedOrderIds.join('|');
    }
    
    generateWaybills = function (){
        var ids = getSelected('selectOrderId');
        if(ids !== ''){
            $('#OrderOrderIds').val(ids);
            $('#generateWaybillsForm').submit();
        }
    }
    
//]]>
</script>
<!--<div style="float: right; padding: 0 0 10px 0;">
<br/>Dla zaznaczonych:
<?php // echo $this->Form->create('Order', array('id' => 'generateWaybillsForm', 'url' => array('action' => 'waybills'))) ?>
<?php // echo $this->Form->button('Generuj listy przewozowe', array('name' => '', 'onclick' => 'generateWaybills(); return false;', 'class'=>'fr')); ?>
<?php // echo $this->Form->hidden('Order.order_ids'); ?>
<?php // echo $this->Form->end(); ?>
</div>-->
<?php //debug($orders); ?>

<table cellpadding="0" cellspacing="0">
        <tr>
            <th style="width:20px">&nbsp;</th>
            <th style="width:80px"><?php echo $this->Paginator->sort('hash', __d('cms', 'Hash')); ?></th>
            <th style="width:217px"><?php echo $this->Paginator->sort('order_status_id', __d('cms', 'Order Status Id')); ?></th>
            <th><?php echo $this->Paginator->sort('customer_id', __d('cms', 'Customer Id')); ?></th>
            <th><?php echo $this->Paginator->sort('created', __d('cms', 'Created')); ?></th>
            <th><?php echo $this->Paginator->sort('total', __d('cms', 'Total')); ?> <span class="currency"><?php __d('commerce', '[PLN]') ?></span></th>
            <th><?php echo __d('cms', 'Dostawa') ?></th>
            <th><?php echo __d('cms', 'Płatność') ?><br /><?php __d('public', 'pozostało') ?></th>
<!--            <th><?php //echo __d('cms', 'Wys. F-vat') ?></th>-->
            <th class="actions"><?php echo __d('cms', 'Actions'); ?></th>
        </tr>
        <?php
        $i = 0;
        foreach ($orders as $k => $order):
            $total = $order['Order']['total'];
            ?>
            <tr class="<?php echo 'row-color-' . $order['Order']['order_status_id']; ?>" fullstatus="<?php echo $order['Order']['fullstatus']; ?>" id="oid_<?php echo $k; ?>">
                <td>
                    <input class="selectOrderId" id="orderId_<?php echo $order['Order']['id']; ?>" type="checkbox" name="data[Order][Order]" value="<?php echo $order['Order']['id']; ?>" /> 
                </td>
                <td><center>
                <?php echo $order['Order']['hash']; ?>&nbsp;
                <?php
//                if ($order['Order']['files_is_not_exist'] == 1) { //Nie ma plików projektu 
//                    echo $this->Html->image('alert.png', array('alt' => "Brak plików projektu", 'title' => "Brak plików projektu"));
//                } elseif ($order['Order']['not_accepted'] == 1) {
//                    echo $this->Html->image('delete.png', array('alt' => "Przynajmniej jeden z plików projektu nie zostal zaakceptowany", 'title' => "Przynajmniej jeden z plików projektu nie zostal zaakceptowany"));
//                } else {
//                    echo $this->Html->image('true.png', array('alt' => "Wszystkie pliki projektu zostały zaakceptowane", 'title' => "Wszystkie pliki projektu zostały zaakceptowane"));
//                }
                ?>
            </center></td>
            <td>
                <?php echo $this->Form->create('Order'); ?>
                <?php echo $this->Form->hidden('id', array('value' => $order['Order']['id'])); ?> 
                <?php echo $this->Form->input('shipment_method_id', array('options' => $orderStatuses, 'label' => false, 'selected' => $order['Order']['order_status_id'], 'class' => 'ChangeStatusForm', 'orderId' => $order['Order']['id'])); ?> 
                <?php echo $this->Form->input('track_number', array('label' => 'Nr listu przew.', 'value' => $order['Order']['track_number'], 'style' => 'width: 102px', 'div' => array('style' => 'display: none'), 'class' => 'ChangeTruckOrderForm', 'orderId' => $order['Order']['id'])); ?> 
                <?php echo $this->Form->end(); ?>           
            </td>
            <td>
                <?php
                echo '<b>' . $order['Order']['invoice_identity']['name'] . '</b>';
                echo $order['Order']['invoice_identity']['name'] == $order['Customer']['contact_person'] ? '' : '<br />' . $order['Customer']['contact_person'];
                ?>
            </td>		
            <td><?php echo $this->FebTime->niceShort($order['Order']['created']); ?>&nbsp;</td>
            <td class="price"><?php echo $this->Number->currency($total, 'PLN'); ?> 
                    <?php //debug($order);  ?>
            </td>
            <td>
                <?php echo $order['ShipmentMethod']['name']; ?>
                <?php echo empty($order['Order']['track_number']) ? '' : '<br />Nr listu: ' . $order['Order']['track_number']; ?> </td>
            <td>
                <?php
                echo !empty($paymentTypes[$order['Order']['payment_type']]) ? $paymentTypes[$order['Order']['payment_type']] : '';
                $paymentTotal = $order['Order']['paymentTotal'];
                $pozostalo = $total - $paymentTotal;
                $poz_styl = $pozostalo ? ' style="color:red;"' : '';
                echo ($pozostalo) >= 0 ? '<br /><span' . $poz_styl . '>Pozostało: ' . $pozostalo . ' ₴' : '</span>';
                echo ($pozostalo) < 0 ? '<br /><span style="font-weight: bold; color:red;">Nadpłata: ' . (-$pozostalo) . ' ₴</span>' : '';
                ?>
            </td>
<!--            <td>-->
                <?php //echo $this->FebHtml->tick($order['Order']['vat']); ?>
<!--            </td>-->
            <td class="actions">
                <?php
                $configure = array(
                    'user_plugin' => 'Commerce',
                    'user_model' => 'Customer',
                    'user_row_id' => $order['Order']['customer_id'],
                    'related_plugin' => 'Commerce',
                    'related_model' => 'Order',
                    'related_row_id' => $order['Order']['id']
                );
                echo $this->element('Payments.button', array('configure' => $configure));
                echo $this->Html->link(__d('cms', 'Edytuj'), array('action' => 'edit', $order['Order']['id']), array('escape' => false, 'alt' => __d('cms', 'Edytuj'), 'class' => 'editorder', 'title' => 'Edytuj'));
                ?>
            </td>
            </tr>
        <?php endforeach; ?>
    </table>
<a href="#" onclick="selectAll('selectOrderId'); return false;"><?php echo __d('public', 'Zaznacz/odznacz wszystkie'); ?></a>
<br />

<?php echo $this->Html->script('/commerce/js/commerce'); ?>
<script type="text/javascript">
    var orders = <?php echo $this->Js->object($orders); ?>
    
    $(function(){
        $('.ChangeStatusForm').each(function(index, object){
            if ($(object).val() == 50) {
                $(object).parents('form').find('div.text').show();
            }
        });          
        
        $('.ChangeTruckOrderForm').change(function(){
            var orderId = $(this).attr('orderId');
            var newValue = $(this).val();
            var toSend = {
                data: {
                    Order: {
                        id: orderId,
                        order_status_id: 50,
                        track_number: newValue
                        
                    }
                }
            };
            
            var answer = confirm("Zapisac numer listu przewozowego?");   
            if (answer) {                                   
                changeOrder('<?php echo $this->Html->url(array('action' => 'ajax_change_order_status')) ?>', toSend, null, null, function(){
                    window.location.href = "<?php echo Router::url(array('plugin' => 'commerce', 'admin' => 'admin', 'controller' => 'orders', 'action' => 'send_order_email')); ?>"+"/"+orderId;
                });
            } else{
                window.location.reload();
            } 
            
        });
        
        $('.ChangeStatusForm').change(function(){
            var orderId = $(this).attr('orderId');
            var newValue = $(this).val();
            var toSend = {
                data: {
                    Order: {
                        id: orderId,
                        order_status_id: newValue
                    }
                }
            };
                
            if (newValue == 50) {
                $(this).parents('form').find('div.text').show();
                return false;
            }
            
            var answer = confirm("Jesteś pewny zmiany statusu zamówienia?");   
            if (answer) {                                   
                changeOrder('<?php echo $this->Html->url(array('action' => 'ajax_change_order_status')) ?>', toSend, null, null, function(){
                    window.location.href = "<?php echo Router::url(array('action' => 'send_order_email')); ?>"+"/"+orderId;
                });
            } else{
                window.location.reload();
            }            
        });
       
        $.each(orders, function(index, order) {
            if ($('#oid_'+index).attr('fullstatus') == 0) {
                $('#oid_'+index).find('select option[value=3]').remove();
                $('#oid_'+index).find('select option[value=4]').remove();
                $('#oid_'+index).find('select option[value=5]').remove();
                $('#oid_'+index).find('select option[value=6]').remove();
                $('#oid_'+index).find('select option[value=7]').remove();
            }
        });
    });
    
</script>