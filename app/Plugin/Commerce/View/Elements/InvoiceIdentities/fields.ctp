<fieldset>
    <legend><?php echo $desc; ?></legend>
    <?php
		echo $this->Form->input('customer_id', array('label' => __d('cms', 'Customer Id')));
		echo $this->Form->input('iscompany', array('label' => __d('cms', 'Iscompany')));
		echo $this->Form->input('name', array('label' => __d('cms', 'Name')));
		echo $this->Form->input('nip', array('label' => __d('cms', 'Nip')));
		echo $this->Form->input('address', array('label' => __d('cms', 'Address')));
		echo $this->Form->input('city', array('label' => __d('cms', 'City')));
		echo $this->Form->input('post_code', array('label' => __d('cms', 'Post Code')));
		echo $this->Form->input('region_id', array('label' => __d('cms', 'Region Id')));
		echo $this->Form->input('country_id', array('label' => __d('cms', 'Country Id')));
	?>
</fieldset>
