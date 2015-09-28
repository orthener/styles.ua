<div class="banners view">
<h2><?php  echo __('Banner');?></h2>
	<dl>
		<dt><?php echo __d('cms', 'Id'); ?></dt>
		<dd>
			<?php echo h($banner['Banner']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Name'); ?></dt>
		<dd>
			<?php echo h($banner['Banner']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Parent Id'); ?></dt>
		<dd>
			<?php echo h($banner['Banner']['parent_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Lft'); ?></dt>
		<dd>
			<?php echo h($banner['Banner']['lft']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Rght'); ?></dt>
		<dd>
			<?php echo h($banner['Banner']['rght']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Created'); ?></dt>
		<dd>
			<?php echo h($banner['Banner']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Modified'); ?></dt>
		<dd>
			<?php echo h($banner['Banner']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Banner'), array('action' => 'edit', $banner['Banner']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Banner'), array('action' => 'delete', $banner['Banner']['id']), null, __('Are you sure you want to delete # %s?', $banner['Banner']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Product Categories'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Banner'), array('action' => 'add')); ?> </li>
	</ul>
</div>
