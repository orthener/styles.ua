	<h2><?php echo __d('cms', 'Order Items');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
	            <th><?php echo $this->Paginator->sort('order_id', __d('cms', 'Order Id'));?></th>
	            <th><?php echo $this->Paginator->sort('product_id', __d('cms', 'Product Id'));?></th>
	            <th><?php echo $this->Paginator->sort('product', __d('cms', 'Product'));?></th>
	            <th><?php echo $this->Paginator->sort('desc', __d('cms', 'Desc'));?></th>
	            <th><?php echo $this->Paginator->sort('name', __d('cms', 'Name'));?></th>
	            <th><?php echo $this->Paginator->sort('price', __d('cms', 'Price'));?></th>
	            <th><?php echo $this->Paginator->sort('tax_rate', __d('cms', 'Tax Rate'));?></th>
	            <th><?php echo $this->Paginator->sort('tax_value', __d('cms', 'Tax Value'));?></th>
	            <th><?php echo $this->Paginator->sort('quantity', __d('cms', 'Quantity'));?></th>
	            <th><?php echo $this->Paginator->sort('discount', __d('cms', 'Discount'));?></th>
	            <th><?php echo $this->Paginator->sort('weight', __d('cms', 'Weight'));?></th>
	            <th><?php echo $this->Paginator->sort('created', __d('cms', 'Created')); ?>&nbsp;&middot;&nbsp;<?php echo $this->Paginator->sort('modified', __d('cms', 'Modified')); ?></th>
	            			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($orderItems as $orderItem): ?>
	<tr attrId="<?php echo $orderItem['OrderItem']['id']; ?>">
		<td>
			<?php echo $this->Permissions->link($orderItem['Order']['id'], array('controller' => 'orders', 'action' => 'view', $orderItem['Order']['id'])); ?>
		</td>
		<td><?php echo h($orderItem['OrderItem']['product_id']); ?>&nbsp;</td>
		<td><?php echo h($orderItem['OrderItem']['product']); ?>&nbsp;</td>
		<td><?php echo h($orderItem['OrderItem']['desc']); ?>&nbsp;</td>
		<td><?php echo h($orderItem['OrderItem']['name']); ?>&nbsp;</td>
		<td><?php echo h($orderItem['OrderItem']['price']); ?>&nbsp;</td>
		<td><?php echo h($orderItem['OrderItem']['tax_rate']); ?>&nbsp;</td>
		<td><?php echo h($orderItem['OrderItem']['tax_value']); ?>&nbsp;</td>
		<td><?php echo h($orderItem['OrderItem']['quantity']); ?>&nbsp;</td>
		<td><?php echo h($orderItem['OrderItem']['discount']); ?>&nbsp;</td>
		<td><?php echo h($orderItem['OrderItem']['weight']); ?>&nbsp;</td>
		<td><?php echo $this->FebTime->niceShort($orderItem['OrderItem']['created']); ?>&nbsp;&middot;&nbsp;<?php echo $this->FebTime->niceShort($orderItem['OrderItem']['modified']); ?></td>
		<td class="actions">
			<?php //echo $this->Permissions->link(__('View'), array('action' => 'view', $orderItem['OrderItem']['id'])); ?>
			<?php echo $this->Permissions->link(__('Edit'), array('action' => 'edit', $orderItem['OrderItem']['id'])); ?>
			<?php echo $this->Permissions->postLink(__('Delete'), array('action' => 'delete', $orderItem['OrderItem']['id']), null, __('Are you sure you want to delete # %s?', $orderItem['OrderItem']['name'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>