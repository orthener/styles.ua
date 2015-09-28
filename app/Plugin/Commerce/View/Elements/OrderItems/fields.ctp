<fieldset>
    <legend><?php echo $desc; ?></legend>
    <?php
		echo $this->Form->input('order_id', array('label' => __d('cms', 'Order Id')));
		echo $this->Form->input('product_id', array('label' => __d('cms', 'Product Id')));
		echo $this->Form->input('product', array('label' => __d('cms', 'Product')));
		echo $this->Form->input('desc', array('label' => __d('cms', 'Desc')));
		echo $this->Form->input('name', array('label' => __d('cms', 'Name')));
		echo $this->Form->input('price', array('label' => __d('cms', 'Price')));
		echo $this->Form->input('tax_rate', array('label' => __d('cms', 'Tax Rate')));
		echo $this->Form->input('tax_value', array('label' => __d('cms', 'Tax Value')));
		echo $this->Form->input('quantity', array('label' => __d('cms', 'Quantity')));
		echo $this->Form->input('discount', array('label' => __d('cms', 'Discount')));
		echo $this->Form->input('weight', array('label' => __d('cms', 'Weight')));
	?>
</fieldset>
