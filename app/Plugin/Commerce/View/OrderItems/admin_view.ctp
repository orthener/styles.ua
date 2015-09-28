<div class="orderItems view">
<h2><?php  echo __('Order Item');?></h2>
	<dl>
		<dt><?php echo __d('cms', 'Id'); ?></dt>
		<dd>
			<?php echo h($orderItem['OrderItem']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Order'); ?></dt>
		<dd>
			<?php echo $this->Html->link($orderItem['Order']['id'], array('controller' => 'orders', 'action' => 'view', $orderItem['Order']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Product Id'); ?></dt>
		<dd>
			<?php echo h($orderItem['OrderItem']['product_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Product'); ?></dt>
		<dd>
			<?php echo h($orderItem['OrderItem']['product']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Desc'); ?></dt>
		<dd>
			<?php echo h($orderItem['OrderItem']['desc']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Name'); ?></dt>
		<dd>
			<?php echo h($orderItem['OrderItem']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Price'); ?></dt>
		<dd>
			<?php echo h($orderItem['OrderItem']['price']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Tax Rate'); ?></dt>
		<dd>
			<?php echo h($orderItem['OrderItem']['tax_rate']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Tax Value'); ?></dt>
		<dd>
			<?php echo h($orderItem['OrderItem']['tax_value']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Quantity'); ?></dt>
		<dd>
			<?php echo h($orderItem['OrderItem']['quantity']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Discount'); ?></dt>
		<dd>
			<?php echo h($orderItem['OrderItem']['discount']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Weight'); ?></dt>
		<dd>
			<?php echo h($orderItem['OrderItem']['weight']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Created'); ?></dt>
		<dd>
			<?php echo h($orderItem['OrderItem']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Modified'); ?></dt>
		<dd>
			<?php echo h($orderItem['OrderItem']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Order Item'), array('action' => 'edit', $orderItem['OrderItem']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Order Item'), array('action' => 'delete', $orderItem['OrderItem']['id']), null, __('Are you sure you want to delete # %s?', $orderItem['OrderItem']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Order Items'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Order Item'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Orders'), array('controller' => 'orders', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Order'), array('controller' => 'orders', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Order Item Files'), array('controller' => 'order_item_files', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Order Item File'), array('controller' => 'order_item_files', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Order Item Files');?></h3>
	<?php if (!empty($orderItem['OrderItemFile'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Order Item Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Accepted'); ?></th>
		<th><?php echo __('Desc'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($orderItem['OrderItemFile'] as $orderItemFile): ?>
		<tr>
			<td><?php echo $orderItemFile['id'];?></td>
			<td><?php echo $orderItemFile['order_item_id'];?></td>
			<td><?php echo $orderItemFile['name'];?></td>
			<td><?php echo $orderItemFile['accepted'];?></td>
			<td><?php echo $orderItemFile['desc'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'order_item_files', 'action' => 'view', $orderItemFile['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'order_item_files', 'action' => 'edit', $orderItemFile['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'order_item_files', 'action' => 'delete', $orderItemFile['id']), null, __('Are you sure you want to delete # %s?', $orderItemFile['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Order Item File'), array('controller' => 'order_item_files', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
