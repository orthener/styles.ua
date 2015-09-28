	<h2><?php echo __d('cms', 'Order Item Files');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
	            <th><?php echo $this->Paginator->sort('order_item_id', __d('cms', 'Order Item Id'));?></th>
	            <th><?php echo $this->Paginator->sort('name', __d('cms', 'Name'));?></th>
	            <th><?php echo $this->Paginator->sort('accepted', __d('cms', 'Accepted'));?></th>
	            <th><?php echo $this->Paginator->sort('desc', __d('cms', 'Desc'));?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($orderItemFiles as $orderItemFile): ?>
	<tr attrId="<?php echo $orderItemFile['OrderItemFile']['id']; ?>">
		<td>
			<?php echo $this->Permissions->link($orderItemFile['OrderItem']['name'], array('controller' => 'order_items', 'action' => 'view', $orderItemFile['OrderItem']['id'])); ?>
		</td>
		<td><?php echo h($orderItemFile['OrderItemFile']['name']); ?>&nbsp;</td>
		<td><?php echo h($orderItemFile['OrderItemFile']['accepted']); ?>&nbsp;</td>
		<td><?php echo h($orderItemFile['OrderItemFile']['desc']); ?>&nbsp;</td>
		<td class="actions">
			<?php //echo $this->Permissions->link(__('View'), array('action' => 'view', $orderItemFile['OrderItemFile']['id'])); ?>
			<?php echo $this->Permissions->link(__('Edit'), array('action' => 'edit', $orderItemFile['OrderItemFile']['id'])); ?>
			<?php echo $this->Permissions->postLink(__('Delete'), array('action' => 'delete', $orderItemFile['OrderItemFile']['id']), null, __('Are you sure you want to delete # %s?', $orderItemFile['OrderItemFile']['name'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>