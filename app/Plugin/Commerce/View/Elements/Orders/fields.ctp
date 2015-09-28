<fieldset>
    <legend><?php echo $desc; ?></legend>
    <?php
		echo $this->Form->input('hash', array('label' => __d('cms', 'Hash')));
		echo $this->Form->input('order_status_id', array('label' => __d('cms', 'Order Status Id')));
		echo $this->Form->input('customer_id', array('label' => __d('cms', 'Customer Id')));
		echo $this->Form->input('address', array('label' => __d('cms', 'Address')));
		echo $this->Form->input('invoice_identity', array('label' => __d('cms', 'Invoice Identity')));
		echo $this->Form->input('shipment_method_id', array('label' => __d('cms', 'Shipment Method Id')));
		echo $this->Form->input('shipment_price', array('label' => __d('cms', 'Shipment Price')));
		echo $this->Form->input('shipment_tax_rate', array('label' => __d('cms', 'Shipment Tax Rate')));
		echo $this->Form->input('shipment_tax_value', array('label' => __d('cms', 'Shipment Tax Value')));
		echo $this->Form->input('shipment_discount', array('label' => __d('cms', 'Shipment Discount')));
		echo $this->Form->input('total', array('label' => __d('cms', 'Total')));
		echo $this->Form->input('total_tax_value', array('label' => __d('cms', 'Total Tax Value')));
		echo $this->Form->input('track_number', array('label' => __d('cms', 'Track Number')));
		echo $this->Form->input('payment_type', array('label' => __d('cms', 'Payment Type')));
		echo $this->Form->input('vat', array('label' => __d('cms', 'Vat')));
	?>
</fieldset>
