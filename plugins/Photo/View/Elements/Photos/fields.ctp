<fieldset>
    <legend><?php echo $desc; ?></legend>
    <?php
		echo $this->FebForm->file('img', array('type' => 'file', 'label' => __d('cms', 'Img')));
		echo $this->Form->input('offer_id', array('label' => __d('cms', 'Offer Id')));
		echo $this->Form->input('page_id', array('label' => __d('cms', 'Page Id')));
		echo $this->Form->input('title', array('label' => __d('cms', 'Title')));
		echo $this->Form->input('order', array('label' => __d('cms', 'Order')));
	?>
</fieldset>
