	<h2><?php echo __d('cms', 'Addresses');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
	            <th><?php echo $this->Paginator->sort('customer_id', __d('cms', 'Customer Id'));?></th>
	            <th><?php echo $this->Paginator->sort('name', __d('cms', 'Name'));?></th>
	            <th><?php echo $this->Paginator->sort('address', __d('cms', 'Address'));?></th>
	            <th><?php echo $this->Paginator->sort('city', __d('cms', 'City'));?></th>
	            <th><?php echo $this->Paginator->sort('post_code', __d('cms', 'Post Code'));?></th>
	            <th><?php echo $this->Paginator->sort('region_id', __d('cms', 'Region Id'));?></th>
	            <th><?php echo $this->Paginator->sort('country_id', __d('cms', 'Country Id'));?></th>
	            <th><?php echo $this->Paginator->sort('phone', __d('cms', 'Phone'));?></th>
	            <th><?php echo $this->Paginator->sort('created', __d('cms', 'Created')); ?>&nbsp;&middot;&nbsp;<?php echo $this->Paginator->sort('modified', __d('cms', 'Modified')); ?></th>
	            			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($addresses as $address): ?>
	<tr attrId="<?php echo $address['Address']['id']; ?>">
		<td>
			<?php echo $this->Permissions->link($address['Customer']['id'], array('controller' => 'customers', 'action' => 'view', $address['Customer']['id'])); ?>
		</td>
		<td><?php echo h($address['Address']['name']); ?>&nbsp;</td>
		<td><?php echo h($address['Address']['address']); ?>&nbsp;</td>
		<td><?php echo h($address['Address']['city']); ?>&nbsp;</td>
		<td><?php echo h($address['Address']['post_code']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Permissions->link($address['Region']['name'], array('controller' => 'regions', 'action' => 'view', $address['Region']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Permissions->link($address['Country']['name'], array('controller' => 'countries', 'action' => 'view', $address['Country']['id'])); ?>
		</td>
		<td><?php echo h($address['Address']['phone']); ?>&nbsp;</td>
		<td><?php echo $this->FebTime->niceShort($address['Address']['created']); ?>&nbsp;&middot;&nbsp;<?php echo $this->FebTime->niceShort($address['Address']['modified']); ?></td>
		<td class="actions">
			<?php //echo $this->Permissions->link(__('View'), array('action' => 'view', $address['Address']['id'])); ?>
			<?php echo $this->Permissions->link(__('Edit'), array('action' => 'edit', $address['Address']['id'])); ?>
			<?php echo $this->Permissions->postLink(__('Delete'), array('action' => 'delete', $address['Address']['id']), null, __('Are you sure you want to delete # %s?', $address['Address']['name'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>