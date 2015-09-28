<?php //debug($products[0]);?>

<?php echo $this->Html->script('jquery-ui-timepicker-addon', array('inline' => true)); ?>

<?php $this->set('title_for_layout', __d('cms', 'List') . ' &bull; ' . __d('cms', 'Products')); ?>
<div class="products index">
    <div class="filters">
        <?php echo $this->Filter->formCreate($filtersSettings, array('legend' => __d('cms', 'Wyszukaj'), 'submit' => __d('cms', 'Wyszukaj'))); ?>
        <?php $this->Paginator->options(array('url' => $filtersParams)); ?>
    </div>
    <?php echo $this->Element('Products/table_index'); ?> 
    <?php echo $this->Element('cms/paginator'); ?>
</div>

<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <?php echo $this->Permissions->link(__d('cms', 'Add Product'), array('action' => 'add'), array('outter' => '<li>%s</li>')); ?>
        <?php //echo $this->Permissions->link(__d('cms', 'Import csv z subiekta'), array('action' => 'import'), array('outter' => '<li>%s</li>')); ?>
        <?php echo $this->Permissions->link(__d('cms', 'Pobierz szablon csv'), '/files/doc/template.csv', array('outter' => '<li>%s</li>')); ?>
        <?php echo $this->Permissions->link(__d('cms', 'Import pliku csv'), array('action' => 'csv_import'), array('outter' => '<li>%s</li>')); ?>
    </ul>
</div>
<script>
    <?php if(!empty($this->params->paging['Product']['options']['order'])) : ?>
        $( document ).ready(function() {
            $('html, body').scrollTop($("table").offset().top);
        });
    <?php endif; ?>

    $('#ProductCreatedBegin').datetimepicker({
        dateFormat: 'yy-mm-dd',
        timeFormat: 'HH:mm',
        hour: 10,
        minute: 00
    }).css({'cursor': 'pointer'});
    $('#ProductCreatedEnd').datetimepicker({
        dateFormat: 'yy-mm-dd',
        timeFormat: 'HH:mm',
        hour: 10,
        minute: 00
    }).css({'cursor': 'pointer'});
    $('#ProductModifiedBegin').datetimepicker({
        dateFormat: 'yy-mm-dd',
        timeFormat: 'HH:mm',
        hour: 10,
        minute: 00
    }).css({'cursor': 'pointer'});
    $('#ProductModifiedEnd').datetimepicker({
        dateFormat: 'yy-mm-dd',
        timeFormat: 'HH:mm',
        hour: 10,
        minute: 00
    }).css({'cursor': 'pointer'});
    $('#ProductPromotionDate').datepicker({
        dateFormat: 'yy-mm-dd',
        /*timeFormat: 'HH:mm',
        hour: 10,
        minute: 00*/
    }).css({'cursor' : 'pointer'});
    $('.product_promotion_date').css('display', 'none');
    $('#ProductPromotionOnPromotion').attr('checked', false);
    $('#ProductPromotionOnPromotion').click(function() {
        $('.product_promotion_date').toggle();
    });
</script>


<?php
echo $this->Form->create("Multiedit", array('url' => array('admin' => 'admin', 'plugin' => 'static_product', 'controller' => 'products', 'action' => 'multi_edit')));
echo $this->Form->hidden('to_send');
echo $this->Form->end(array('label' => __d('cms', 'Edytuj zaznaczone'), 'id' => "edytuj_zaznaczone"));
?>
<script>
    $("#edytuj_zaznaczone").click(function() {
        var selectedProducts = new Array();
        $('table input:checked').each(function() {
            selectedProducts.push(this.value);
        });
        var toSend = selectedProducts.join('|');
        $('#MultieditToSend').val(toSend);
    });

//    generateWaybills = function() {
//        var ids = getSelected('selectOrderId');
//        if (ids !== '') {
//            $('#OrderOrderIds').val(ids);
//            $('#generateWaybillsForm').submit();
//        }
//    }
</script>