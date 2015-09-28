<fieldset>
    <legend><?php echo __d('cms', 'Banner Data'); ?></legend>
    <?php
		echo $this->Form->input('name', array('label' => __d('cms', 'Name')));
		echo $this->FebForm->file('img', array('label' => __d('cms', 'Image')));
		echo $this->Form->input('link', array('label' => __d('cms', 'Url')));
		echo $this->Form->input('new_window', array('type'=>'checkbox','label' => __d('cms', 'Otwieraj w nowym oknie')));
	?>
</fieldset>
