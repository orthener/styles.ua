	<h2><?php echo __d('cms', 'Customers');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
	            <th><?php echo $this->Paginator->sort('user_id', __d('cms', 'User Id'));?></th>
	            <th><?php echo $this->Paginator->sort('contact_person', __d('cms', 'Contact Person'));?></th>
	            <th><?php echo $this->Paginator->sort('email', __d('cms', 'Email'));?></th>
	            <th><?php echo $this->Paginator->sort('phone', __d('cms', 'Phone'));?></th>
	            <th><?php echo $this->Paginator->sort('address_id', __d('cms', 'Address Id'));?></th>
	            <th><?php echo $this->Paginator->sort('invoice_identity_id', __d('cms', 'Invoice Identity Id'));?></th>
	            <th><?php echo $this->Paginator->sort('discount', __d('cms', 'Discount'));?></th>
	            <th><?php echo $this->Paginator->sort('created', __d('cms', 'Created')); ?>&nbsp;&middot;&nbsp;<?php echo $this->Paginator->sort('modified', __d('cms', 'Modified')); ?></th>
	            			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($customers as $customer): ?>
	<tr attrId="<?php echo $customer['Customer']['id']; ?>">
		<td>
			<?php echo $this->Permissions->link($customer['User']['name'], array('controller' => 'users', 'action' => 'view', $customer['User']['id'])); ?>
		</td>
		<td><?php echo h($customer['Customer']['contact_person']); ?>&nbsp;</td>
		<td><?php echo h($customer['Customer']['email']); ?>&nbsp;</td>
		<td><?php echo h($customer['Customer']['phone']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Permissions->link($customer['InvoiceIdentityDefault']['name'], array('controller' => 'addresses', 'action' => 'view', $customer['InvoiceIdentityDefault']['id'])); ?>
		</td>
		<td><?php echo h($customer['Customer']['invoice_identity_id']); ?>&nbsp;</td>
		<td><?php echo h($customer['Customer']['discount']); ?>&nbsp;</td>
		<td><?php echo $this->FebTime->niceShort($customer['Customer']['created']); ?>&nbsp;&middot;&nbsp;<?php echo $this->FebTime->niceShort($customer['Customer']['modified']); ?></td>
		<td class="actions">
			<?php //echo $this->Permissions->link(__('View'), array('action' => 'view', $customer['Customer']['id'])); ?>
			<?php echo $this->Permissions->link(__('Edit'), array('action' => 'edit', $customer['Customer']['id'])); ?>
			<?php echo $this->Permissions->postLink(__d('cms', 'Delete'), array('action' => 'delete', $customer['Customer']['id']), null, __('Are you sure you want to delete # %s?', $customer['Customer']['contact_person'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>