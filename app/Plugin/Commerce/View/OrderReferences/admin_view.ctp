<div class="orderReferences view">
<h2><?php  echo __('Order Reference');?></h2>
	<dl>
		<dt><?php echo __d('cms', 'Id'); ?></dt>
		<dd>
			<?php echo h($orderReference['OrderReference']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Name'); ?></dt>
		<dd>
			<?php echo h($orderReference['OrderReference']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Phone'); ?></dt>
		<dd>
			<?php echo h($orderReference['OrderReference']['phone']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Created'); ?></dt>
		<dd>
			<?php echo h($orderReference['OrderReference']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Modified'); ?></dt>
		<dd>
			<?php echo h($orderReference['OrderReference']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Order Reference'), array('action' => 'edit', $orderReference['OrderReference']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Order Reference'), array('action' => 'delete', $orderReference['OrderReference']['id']), null, __('Are you sure you want to delete # %s?', $orderReference['OrderReference']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Order References'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Order Reference'), array('action' => 'add')); ?> </li>
	</ul>
</div>
