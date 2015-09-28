<div class="infoCategories view">
<h2><?php  echo __('Info Category');?></h2>
	<dl>
		<dt><?php echo __d('cms', 'Id'); ?></dt>
		<dd>
			<?php echo h($infoCategory['InfoCategory']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Name'); ?></dt>
		<dd>
			<?php echo h($infoCategory['InfoCategory']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Modified'); ?></dt>
		<dd>
			<?php echo h($infoCategory['InfoCategory']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Created'); ?></dt>
		<dd>
			<?php echo h($infoCategory['InfoCategory']['created']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Info Category'), array('action' => 'edit', $infoCategory['InfoCategory']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Info Category'), array('action' => 'delete', $infoCategory['InfoCategory']['id']), null, __('Are you sure you want to delete # %s?', $infoCategory['InfoCategory']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Info Categories'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Info Category'), array('action' => 'add')); ?> </li>
	</ul>
</div>
