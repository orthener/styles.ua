<fieldset>
    <legend><?php echo $desc; ?></legend>
    <?php
		echo $this->Form->input('model', array('label' => __d('cms', 'model')));
		echo $this->Form->input('row_id', array('label' => __d('cms', 'row_id')));
		echo $this->Form->input('selected', array('label' => __d('cms', 'selected')));
	?>
</fieldset>
