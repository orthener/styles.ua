<div class="customers view">
<h2><?php  echo __('Customer');?></h2>
	<dl>
		<dt><?php echo __d('cms', 'Id'); ?></dt>
		<dd>
			<?php echo h($customer['Customer']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($customer['User']['name'], array('controller' => 'users', 'action' => 'view', $customer['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Contact Person'); ?></dt>
		<dd>
			<?php echo h($customer['Customer']['contact_person']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Email'); ?></dt>
		<dd>
			<?php echo h($customer['Customer']['email']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Phone'); ?></dt>
		<dd>
			<?php echo h($customer['Customer']['phone']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Address'); ?></dt>
		<dd>
			<?php echo $this->Html->link($customer['Address']['name'], array('controller' => 'addresses', 'action' => 'view', $customer['Address']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Invoice Identity Id'); ?></dt>
		<dd>
			<?php echo h($customer['Customer']['invoice_identity_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Discount'); ?></dt>
		<dd>
			<?php echo h($customer['Customer']['discount']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Created'); ?></dt>
		<dd>
			<?php echo h($customer['Customer']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Modified'); ?></dt>
		<dd>
			<?php echo h($customer['Customer']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Customer'), array('action' => 'edit', $customer['Customer']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Customer'), array('action' => 'delete', $customer['Customer']['id']), null, __('Are you sure you want to delete # %s?', $customer['Customer']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Customers'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Customer'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Addresses'), array('controller' => 'addresses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Address'), array('controller' => 'addresses', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Invoice Identities'), array('controller' => 'invoice_identities', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Invoice Identity'), array('controller' => 'invoice_identities', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Orders'), array('controller' => 'orders', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Order'), array('controller' => 'orders', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Addresses');?></h3>
	<?php if (!empty($customer['Address'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Customer Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Address'); ?></th>
		<th><?php echo __('City'); ?></th>
		<th><?php echo __('Post Code'); ?></th>
		<th><?php echo __('Region Id'); ?></th>
		<th><?php echo __('Country Id'); ?></th>
		<th><?php echo __('Phone'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($customer['Address'] as $address): ?>
		<tr>
			<td><?php echo $address['id'];?></td>
			<td><?php echo $address['customer_id'];?></td>
			<td><?php echo $address['name'];?></td>
			<td><?php echo $address['address'];?></td>
			<td><?php echo $address['city'];?></td>
			<td><?php echo $address['post_code'];?></td>
			<td><?php echo $address['region_id'];?></td>
			<td><?php echo $address['country_id'];?></td>
			<td><?php echo $address['phone'];?></td>
			<td><?php echo $address['created'];?></td>
			<td><?php echo $address['modified'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'addresses', 'action' => 'view', $address['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'addresses', 'action' => 'edit', $address['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'addresses', 'action' => 'delete', $address['id']), null, __('Are you sure you want to delete # %s?', $address['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Address'), array('controller' => 'addresses', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Invoice Identities');?></h3>
	<?php if (!empty($customer['InvoiceIdentity'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Customer Id'); ?></th>
		<th><?php echo __('Iscompany'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Nip'); ?></th>
		<th><?php echo __('Address'); ?></th>
		<th><?php echo __('City'); ?></th>
		<th><?php echo __('Post Code'); ?></th>
		<th><?php echo __('Region Id'); ?></th>
		<th><?php echo __('Country Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($customer['InvoiceIdentity'] as $invoiceIdentity): ?>
		<tr>
			<td><?php echo $invoiceIdentity['id'];?></td>
			<td><?php echo $invoiceIdentity['customer_id'];?></td>
			<td><?php echo $invoiceIdentity['iscompany'];?></td>
			<td><?php echo $invoiceIdentity['name'];?></td>
			<td><?php echo $invoiceIdentity['nip'];?></td>
			<td><?php echo $invoiceIdentity['address'];?></td>
			<td><?php echo $invoiceIdentity['city'];?></td>
			<td><?php echo $invoiceIdentity['post_code'];?></td>
			<td><?php echo $invoiceIdentity['region_id'];?></td>
			<td><?php echo $invoiceIdentity['country_id'];?></td>
			<td><?php echo $invoiceIdentity['created'];?></td>
			<td><?php echo $invoiceIdentity['modified'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'invoice_identities', 'action' => 'view', $invoiceIdentity['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'invoice_identities', 'action' => 'edit', $invoiceIdentity['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'invoice_identities', 'action' => 'delete', $invoiceIdentity['id']), null, __('Are you sure you want to delete # %s?', $invoiceIdentity['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Invoice Identity'), array('controller' => 'invoice_identities', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Orders');?></h3>
	<?php if (!empty($customer['Order'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Hash'); ?></th>
		<th><?php echo __('Order Status Id'); ?></th>
		<th><?php echo __('Customer Id'); ?></th>
		<th><?php echo __('Address'); ?></th>
		<th><?php echo __('Invoice Identity'); ?></th>
		<th><?php echo __('Shipment Method Id'); ?></th>
		<th><?php echo __('Shipment Price'); ?></th>
		<th><?php echo __('Shipment Tax Rate'); ?></th>
		<th><?php echo __('Shipment Tax Value'); ?></th>
		<th><?php echo __('Shipment Discount'); ?></th>
		<th><?php echo __('Total'); ?></th>
		<th><?php echo __('Total Tax Value'); ?></th>
		<th><?php echo __('Track Number'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th><?php echo __('Payment Type'); ?></th>
		<th><?php echo __('Vat'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($customer['Order'] as $order): ?>
		<tr>
			<td><?php echo $order['id'];?></td>
			<td><?php echo $order['hash'];?></td>
			<td><?php echo $order['order_status_id'];?></td>
			<td><?php echo $order['customer_id'];?></td>
			<td><?php echo $order['address'];?></td>
			<td><?php echo $order['invoice_identity'];?></td>
			<td><?php echo $order['shipment_method_id'];?></td>
			<td><?php echo $order['shipment_price'];?></td>
			<td><?php echo $order['shipment_tax_rate'];?></td>
			<td><?php echo $order['shipment_tax_value'];?></td>
			<td><?php echo $order['shipment_discount'];?></td>
			<td><?php echo $order['total'];?></td>
			<td><?php echo $order['total_tax_value'];?></td>
			<td><?php echo $order['track_number'];?></td>
			<td><?php echo $order['created'];?></td>
			<td><?php echo $order['modified'];?></td>
			<td><?php echo $order['payment_type'];?></td>
			<td><?php echo $order['vat'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'orders', 'action' => 'view', $order['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'orders', 'action' => 'edit', $order['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'orders', 'action' => 'delete', $order['id']), null, __('Are you sure you want to delete # %s?', $order['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Order'), array('controller' => 'orders', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
