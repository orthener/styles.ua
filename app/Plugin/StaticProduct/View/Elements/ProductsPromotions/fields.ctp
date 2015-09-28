<?php echo $this->Html->script('jquery-ui-timepicker-addon', array('inline' => true)); ?>
<?php echo $this->Html->script('jquery.ui.datepicker-pl', array('inline' => true)); ?>
<fieldset>
    <legend><?php echo __d('cms', 'Dodawanie promocji'); ?></legend>
    <?php
    echo $this->Form->hidden('product_id');
    echo $this->Form->input('date_from', array('type' => 'text', 'label' => __d('cms', 'Data od ')));
    echo $this->Form->input('date_to', array('type' => 'text', 'label' => __d('cms', 'Data do ')));
    echo $this->Form->input('price', array('label' => __d('cms', 'Nowa Cena')));
    ?>
</fieldset>


<script type="text/javascript">
    //<![CDATA[
    $('#ProductsPromotionDateFrom').datetimepicker({
        dateFormat: 'yy-mm-dd',
        timeFormat: 'HH:mm',
        hour: 10,
        minute: 00
    }).css({'cursor': 'pointer'});
    $('#ProductsPromotionDateTo').datetimepicker({
        dateFormat: 'yy-mm-dd',
        timeFormat: 'HH:mm',
        hour: 10,
        minute: 00
    }).css({'cursor': 'pointer'});
    //]]>
</script>