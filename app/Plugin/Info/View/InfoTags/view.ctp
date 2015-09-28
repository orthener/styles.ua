<div class="infoTags view">
<h2><?php  echo __('Info Tag');?></h2>
	<dl>
		<dt><?php echo __d('cms', 'Id'); ?></dt>
		<dd>
			<?php echo h($infoTag['InfoTag']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Name'); ?></dt>
		<dd>
			<?php echo h($infoTag['InfoTag']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Count'); ?></dt>
		<dd>
			<?php echo h($infoTag['InfoTag']['count']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Modified'); ?></dt>
		<dd>
			<?php echo h($infoTag['InfoTag']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Created'); ?></dt>
		<dd>
			<?php echo h($infoTag['InfoTag']['created']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Info Tag'), array('action' => 'edit', $infoTag['InfoTag']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Info Tag'), array('action' => 'delete', $infoTag['InfoTag']['id']), null, __('Are you sure you want to delete # %s?', $infoTag['InfoTag']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Info Tags'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Info Tag'), array('action' => 'add')); ?> </li>
	</ul>
</div>
