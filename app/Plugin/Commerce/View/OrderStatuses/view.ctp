<div class="orderStatuses view">
<h2><?php  echo __('Order Status');?></h2>
	<dl>
		<dt><?php echo __d('cms', 'Id'); ?></dt>
		<dd>
			<?php echo h($orderStatus['OrderStatus']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Name'); ?></dt>
		<dd>
			<?php echo h($orderStatus['OrderStatus']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Created'); ?></dt>
		<dd>
			<?php echo h($orderStatus['OrderStatus']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Modified'); ?></dt>
		<dd>
			<?php echo h($orderStatus['OrderStatus']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Deleted'); ?></dt>
		<dd>
			<?php echo h($orderStatus['OrderStatus']['deleted']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Order Status'), array('action' => 'edit', $orderStatus['OrderStatus']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Order Status'), array('action' => 'delete', $orderStatus['OrderStatus']['id']), null, __('Are you sure you want to delete # %s?', $orderStatus['OrderStatus']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Order Statuses'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Order Status'), array('action' => 'add')); ?> </li>
	</ul>
</div>
