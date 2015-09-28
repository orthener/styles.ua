<fieldset>
    <legend><?php echo $desc; ?></legend>
    <?php
		echo $this->Form->input('order_item_id', array('label' => __d('cms', 'Order Item Id')));
		echo $this->Form->input('name', array('label' => __d('cms', 'Name')));
		echo $this->Form->input('accepted', array('label' => __d('cms', 'Accepted')));
		echo $this->Form->input('desc', array('label' => __d('cms', 'Desc')));
	?>
</fieldset>
