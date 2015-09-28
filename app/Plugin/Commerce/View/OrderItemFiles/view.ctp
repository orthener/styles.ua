<div class="orderItemFiles view">
<h2><?php  echo __('Order Item File');?></h2>
	<dl>
		<dt><?php echo __d('cms', 'Id'); ?></dt>
		<dd>
			<?php echo h($orderItemFile['OrderItemFile']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Order Item'); ?></dt>
		<dd>
			<?php echo $this->Html->link($orderItemFile['OrderItem']['name'], array('controller' => 'order_items', 'action' => 'view', $orderItemFile['OrderItem']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Name'); ?></dt>
		<dd>
			<?php echo h($orderItemFile['OrderItemFile']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Accepted'); ?></dt>
		<dd>
			<?php echo h($orderItemFile['OrderItemFile']['accepted']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Desc'); ?></dt>
		<dd>
			<?php echo h($orderItemFile['OrderItemFile']['desc']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Order Item File'), array('action' => 'edit', $orderItemFile['OrderItemFile']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Order Item File'), array('action' => 'delete', $orderItemFile['OrderItemFile']['id']), null, __('Are you sure you want to delete # %s?', $orderItemFile['OrderItemFile']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Order Item Files'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Order Item File'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Order Items'), array('controller' => 'order_items', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Order Item'), array('controller' => 'order_items', 'action' => 'add')); ?> </li>
	</ul>
</div>
