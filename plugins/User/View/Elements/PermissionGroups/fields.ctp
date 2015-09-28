<fieldset>
    <legend><?php echo __d('cms', 'Permission Group Data'); ?></legend>
    <?php
		echo $this->Form->hidden('permission_category_id');
		echo $this->Form->input('name', array('label' => __d('cms', 'Name')));
	?>
</fieldset>