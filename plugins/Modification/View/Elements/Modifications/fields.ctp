<fieldset>
    <legend><?php echo $desc; ?></legend>
    <?php
		echo $this->Form->input('user_id', array('label' => __d('cms', 'User Id')));
		echo $this->Form->input('model', array('label' => __d('cms', 'Model')));
		echo $this->Form->input('foreign_key', array('label' => __d('cms', 'Foreign Key')));
		echo $this->Form->input('action', array('label' => __d('cms', 'Action')));
		echo $this->Form->input('user_details', array('label' => __d('cms', 'User Details')));
		echo $this->Form->input('content_before', array('label' => __d('cms', 'Content Before')));
		echo $this->Form->input('content_after', array('label' => __d('cms', 'Content After')));
	?>
</fieldset>
