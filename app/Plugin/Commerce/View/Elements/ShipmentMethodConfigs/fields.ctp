<fieldset>
    <legend><?php echo $desc; ?></legend>
    <?php
		echo $this->Form->input('shipment_method_id', array('label' => __d('cms', 'Metoda dostawy')));
		echo $this->Form->input('weight', array('label' => __d('cms', 'Weight'), 'after' => 'kg'));
		echo $this->Form->input('price', array('label' => __d('cms', 'Price')));
		echo $this->Form->input('tax_rate', array('options' => $taxRates, 'label' => __d('cms', 'Tax Rate'), 'default' => '0.23'));
	?>
</fieldset>
