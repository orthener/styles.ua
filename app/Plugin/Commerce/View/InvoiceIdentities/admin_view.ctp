<div class="invoiceIdentities view">
<h2><?php  echo __('Invoice Identity');?></h2>
	<dl>
		<dt><?php echo __d('cms', 'Id'); ?></dt>
		<dd>
			<?php echo h($invoiceIdentity['InvoiceIdentity']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Customer'); ?></dt>
		<dd>
			<?php echo $this->Html->link($invoiceIdentity['Customer']['contact_person'], array('controller' => 'customers', 'action' => 'view', $invoiceIdentity['Customer']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Iscompany'); ?></dt>
		<dd>
			<?php echo h($invoiceIdentity['InvoiceIdentity']['iscompany']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Name'); ?></dt>
		<dd>
			<?php echo h($invoiceIdentity['InvoiceIdentity']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Nip'); ?></dt>
		<dd>
			<?php echo h($invoiceIdentity['InvoiceIdentity']['nip']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Address'); ?></dt>
		<dd>
			<?php echo h($invoiceIdentity['InvoiceIdentity']['address']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'City'); ?></dt>
		<dd>
			<?php echo h($invoiceIdentity['InvoiceIdentity']['city']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Post Code'); ?></dt>
		<dd>
			<?php echo h($invoiceIdentity['InvoiceIdentity']['post_code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Region'); ?></dt>
		<dd>
			<?php echo $this->Html->link($invoiceIdentity['Region']['name'], array('controller' => 'regions', 'action' => 'view', $invoiceIdentity['Region']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Country'); ?></dt>
		<dd>
			<?php echo $this->Html->link($invoiceIdentity['Country']['name'], array('controller' => 'countries', 'action' => 'view', $invoiceIdentity['Country']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Created'); ?></dt>
		<dd>
			<?php echo h($invoiceIdentity['InvoiceIdentity']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Modified'); ?></dt>
		<dd>
			<?php echo h($invoiceIdentity['InvoiceIdentity']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Invoice Identity'), array('action' => 'edit', $invoiceIdentity['InvoiceIdentity']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Invoice Identity'), array('action' => 'delete', $invoiceIdentity['InvoiceIdentity']['id']), null, __('Are you sure you want to delete # %s?', $invoiceIdentity['InvoiceIdentity']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Invoice Identities'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Invoice Identity'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Customers'), array('controller' => 'customers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Customer'), array('controller' => 'customers', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Regions'), array('controller' => 'regions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Region'), array('controller' => 'regions', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Countries'), array('controller' => 'countries', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Country'), array('controller' => 'countries', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Customers');?></h3>
	<?php if (!empty($invoiceIdentity['Customer'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Contact Person'); ?></th>
		<th><?php echo __('Email'); ?></th>
		<th><?php echo __('Phone'); ?></th>
		<th><?php echo __('Address Id'); ?></th>
		<th><?php echo __('Invoice Identity Id'); ?></th>
		<th><?php echo __('Discount'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($invoiceIdentity['Customer'] as $customer): ?>
		<tr>
			<td><?php echo $customer['id'];?></td>
			<td><?php echo $customer['user_id'];?></td>
			<td><?php echo $customer['contact_person'];?></td>
			<td><?php echo $customer['email'];?></td>
			<td><?php echo $customer['phone'];?></td>
			<td><?php echo $customer['address_id'];?></td>
			<td><?php echo $customer['invoice_identity_id'];?></td>
			<td><?php echo $customer['discount'];?></td>
			<td><?php echo $customer['created'];?></td>
			<td><?php echo $customer['modified'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'customers', 'action' => 'view', $customer['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'customers', 'action' => 'edit', $customer['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'customers', 'action' => 'delete', $customer['id']), null, __('Are you sure you want to delete # %s?', $customer['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Customer'), array('controller' => 'customers', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
