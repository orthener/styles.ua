<fieldset>
    <legend><?php echo __d('cms', 'Promotion Code Data'); ?></legend>
    <?php
		echo $this->Form->input('code', array('label' => __d('cms', 'Code')));
		echo $this->Form->input('single', array('default' => 1, 'label' => __d('cms', 'Jednokrotnego użytku')));
		echo $this->Form->input('value', array('label' => __d('cms', 'Value'), 'style' => 'width: 30px;', 'after' => '%'));
		echo $this->Form->input('expiry_date', array('type' => 'text', 'label' => __d('cms', 'Expiry Date')));
//		echo $this->Form->input('used', array('label' => __d('cms', 'Used')));
//		echo $this->Form->input('deleted', array('label' => __d('cms', 'Deleted')));
	?>
</fieldset>
<script type="text/javascript">
    $(function(){
        $('#PromotionCodeExpiryDate').datepicker({
            dateFormat: 'yy-mm-dd'//'dd.mm.yy',
        });
    });
</script>