<fieldset>
    <legend><?php echo __d('cms', 'Order Reference Data'); ?></legend>
    <?php
		echo $this->Form->input('name', array('label' => __d('cms', 'Name')));
		echo $this->Form->input('phone', array('label' => __d('cms', 'Phone')));
	?>
</fieldset>
