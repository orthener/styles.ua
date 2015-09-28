<fieldset>
    <legend><?php echo $desc; ?></legend>
    <?php
		echo $this->Form->input('title', array('label' => __d('cms', 'Title')));
		echo $this->Form->input('user_id', array('label' => __d('cms', 'User Id')));
		echo $this->Form->input('row_id', array('label' => __d('cms', 'Row Id')));
		echo $this->Form->input('model', array('label' => __d('cms', 'Model')));
		echo $this->Form->input('content', array('label' => __d('cms', 'Content')));
	?>
</fieldset>
