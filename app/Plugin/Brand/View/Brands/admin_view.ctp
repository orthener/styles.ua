<div class="brands view">
<h2><?php  echo __('Brand');?></h2>
	<dl>
		<dt><?php echo __d('cms', 'Id'); ?></dt>
		<dd>
			<?php echo h($brand['Brand']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Name'); ?></dt>
		<dd>
			<?php echo h($brand['Brand']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Img'); ?></dt>
		<dd>
			<?php echo h($brand['Brand']['img']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Desc'); ?></dt>
		<dd>
			<?php echo h($brand['Brand']['desc']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Slug'); ?></dt>
		<dd>
			<?php echo h($brand['Brand']['slug']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Img2'); ?></dt>
		<dd>
			<?php echo h($brand['Brand']['img2']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Created'); ?></dt>
		<dd>
			<?php echo h($brand['Brand']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Modified'); ?></dt>
		<dd>
			<?php echo h($brand['Brand']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Brand'), array('action' => 'edit', $brand['Brand']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Brand'), array('action' => 'delete', $brand['Brand']['id']), null, __('Are you sure you want to delete # %s?', $brand['Brand']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Brands'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Brand'), array('action' => 'add')); ?> </li>
	</ul>
</div>
