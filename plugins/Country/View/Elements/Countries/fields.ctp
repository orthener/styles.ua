<fieldset>
    <legend><?php echo $desc; ?></legend>
    <?php
		echo $this->Form->input('name', array('label' => __d('cms', 'Name')));
		echo $this->Form->input('printable_name_en', array('label' => __d('cms', 'Printable Name En')));
		echo $this->Form->input('printable_name', array('label' => __d('cms', 'Printable Name')));
		echo $this->Form->input('iso3', array('label' => __d('cms', 'Iso3')));
		echo $this->Form->input('numcode', array('label' => __d('cms', 'Numcode')));
	?>
</fieldset>
