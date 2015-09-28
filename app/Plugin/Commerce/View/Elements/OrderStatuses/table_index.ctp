	<h2><?php echo __d('cms', 'Order Statuses');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
	            <th><?php echo $this->Paginator->sort('name', __d('cms', 'Name'));?></th>
	            <th><?php echo $this->Paginator->sort('created', __d('cms', 'Created')); ?>&nbsp;&middot;&nbsp;<?php echo $this->Paginator->sort('modified', __d('cms', 'Modified')); ?></th>
	            	            <th><?php echo $this->Paginator->sort('deleted', __d('cms', 'Deleted'));?></th>
			<th class="actions"><?php echo __d('cms', 'Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($orderStatuses as $orderStatus): ?>
	<tr attrId="<?php echo $orderStatus['OrderStatus']['id']; ?>">
		<td><?php echo h($orderStatus['OrderStatus']['name']); ?>&nbsp;</td>
		<td><?php echo h($orderStatus['OrderStatus']['deleted']); ?>&nbsp;</td>
		<td><?php echo $this->FebTime->niceShort($orderStatus['OrderStatus']['created']); ?>&nbsp;&middot;&nbsp;<?php echo $this->FebTime->niceShort($orderStatus['OrderStatus']['modified']); ?></td>
		<td class="actions">
			<?php //echo $this->Permissions->link(__('View'), array('action' => 'view', $orderStatus['OrderStatus']['id'])); ?>
			<?php echo $this->Permissions->link(__('Edit'), array('action' => 'edit', $orderStatus['OrderStatus']['id'])); ?>
			<?php echo $this->Permissions->postLink(__d('cms', 'Delete'), array('action' => 'delete', $orderStatus['OrderStatus']['id']), null, __('Are you sure you want to delete # %s?', $orderStatus['OrderStatus']['name'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>