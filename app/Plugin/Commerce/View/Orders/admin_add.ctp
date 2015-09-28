<div class="orders form">
<?php echo $this->Form->create('Order');?>
	<fieldset>
 		<legend><?php echo __('Admin Add Order'); ?></legend>
	<?php
		echo $this->Form->input('hash');
		echo $this->Form->input('order_status_id');
		echo $this->Form->input('customer_id');
		echo $this->Form->input('address');
		echo $this->Form->input('invoice_identity');
		echo $this->Form->input('shipment_method_id');
		echo $this->Form->input('shipment_price');
		echo $this->Form->input('shipment_tax_rate');
		echo $this->Form->input('shipment_tax_value');
		echo $this->Form->input('total');
		echo $this->Form->input('total_tax_value');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Orders'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Order Statuses'), array('controller' => 'order_statuses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Order Status'), array('controller' => 'order_statuses', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Customers'), array('controller' => 'customers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Customer'), array('controller' => 'customers', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Shipment Methods'), array('controller' => 'shipment_methods', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Shipment Method'), array('controller' => 'shipment_methods', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Order Items'), array('controller' => 'order_items', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Order Item'), array('controller' => 'order_items', 'action' => 'add')); ?> </li>
	</ul>
</div>