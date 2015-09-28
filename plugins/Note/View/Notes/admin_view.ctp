<div class="notes view">
<h2><?php  echo __d('cms', 'Note');?></h2>
	<dl>
		<dt><?php echo __d('cms', 'Id'); ?></dt>
		<dd>
			<?php echo h($note['Note']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Title'); ?></dt>
		<dd>
			<?php echo h($note['Note']['title']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($note['User']['name'], array('controller' => 'users', 'action' => 'view', $note['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Row Id'); ?></dt>
		<dd>
			<?php echo h($note['Note']['row_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Model'); ?></dt>
		<dd>
			<?php echo h($note['Note']['model']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Content'); ?></dt>
		<dd>
			<?php echo h($note['Note']['content']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Modified'); ?></dt>
		<dd>
			<?php echo h($note['Note']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Created'); ?></dt>
		<dd>
			<?php echo h($note['Note']['created']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __d('cms', 'Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__d('cms', 'Edit Note'), array('action' => 'edit', $note['Note']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__d('cms', 'Delete Note'), array('action' => 'delete', $note['Note']['id']), null, __d('cms', 'Are you sure you want to delete # %s?', $note['Note']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__d('cms', 'List Notes'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__d('cms', 'New Note'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__d('cms', 'List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__d('cms', 'New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
