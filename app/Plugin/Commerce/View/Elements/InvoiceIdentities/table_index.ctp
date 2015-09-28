	<h2><?php echo __d('cms', 'Invoice Identities');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
	            <th><?php echo $this->Paginator->sort('customer_id', __d('cms', 'Customer Id'));?></th>
	            <th><?php echo $this->Paginator->sort('iscompany', __d('cms', 'Iscompany'));?></th>
	            <th><?php echo $this->Paginator->sort('name', __d('cms', 'Name'));?></th>
	            <th><?php echo $this->Paginator->sort('nip', __d('cms', 'Nip'));?></th>
	            <th><?php echo $this->Paginator->sort('address', __d('cms', 'Address'));?></th>
	            <th><?php echo $this->Paginator->sort('city', __d('cms', 'City'));?></th>
	            <th><?php echo $this->Paginator->sort('post_code', __d('cms', 'Post Code'));?></th>
	            <th><?php echo $this->Paginator->sort('region_id', __d('cms', 'Region Id'));?></th>
	            <th><?php echo $this->Paginator->sort('country_id', __d('cms', 'Country Id'));?></th>
	            <th><?php echo $this->Paginator->sort('created', __d('cms', 'Created')); ?>&nbsp;&middot;&nbsp;<?php echo $this->Paginator->sort('modified', __d('cms', 'Modified')); ?></th>
	            			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($invoiceIdentities as $invoiceIdentity): ?>
	<tr attrId="<?php echo $invoiceIdentity['InvoiceIdentity']['id']; ?>">
		<td>
			<?php echo $this->Permissions->link($invoiceIdentity['Customer']['contact_person'], array('controller' => 'customers', 'action' => 'view', $invoiceIdentity['Customer']['id'])); ?>
		</td>
		<td><?php echo h($invoiceIdentity['InvoiceIdentity']['iscompany']); ?>&nbsp;</td>
		<td><?php echo h($invoiceIdentity['InvoiceIdentity']['name']); ?>&nbsp;</td>
		<td><?php echo h($invoiceIdentity['InvoiceIdentity']['nip']); ?>&nbsp;</td>
		<td><?php echo h($invoiceIdentity['InvoiceIdentity']['address']); ?>&nbsp;</td>
		<td><?php echo h($invoiceIdentity['InvoiceIdentity']['city']); ?>&nbsp;</td>
		<td><?php echo h($invoiceIdentity['InvoiceIdentity']['post_code']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Permissions->link($invoiceIdentity['Region']['name'], array('controller' => 'regions', 'action' => 'view', $invoiceIdentity['Region']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Permissions->link($invoiceIdentity['Country']['name'], array('controller' => 'countries', 'action' => 'view', $invoiceIdentity['Country']['id'])); ?>
		</td>
		<td><?php echo $this->FebTime->niceShort($invoiceIdentity['InvoiceIdentity']['created']); ?>&nbsp;&middot;&nbsp;<?php echo $this->FebTime->niceShort($invoiceIdentity['InvoiceIdentity']['modified']); ?></td>
		<td class="actions">
			<?php //echo $this->Permissions->link(__('View'), array('action' => 'view', $invoiceIdentity['InvoiceIdentity']['id'])); ?>
			<?php echo $this->Permissions->link(__('Edit'), array('action' => 'edit', $invoiceIdentity['InvoiceIdentity']['id'])); ?>
			<?php echo $this->Permissions->postLink(__('Delete'), array('action' => 'delete', $invoiceIdentity['InvoiceIdentity']['id']), null, __('Are you sure you want to delete # %s?', $invoiceIdentity['InvoiceIdentity']['name'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>