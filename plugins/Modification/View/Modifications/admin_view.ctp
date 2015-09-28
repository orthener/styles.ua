<div class="modifications view">
<h2><?php  echo __d('cms', 'Modification');?></h2>
	<dl>
		<dt><?php echo __d('cms', 'Id'); ?></dt>
		<dd>
			<?php echo h($modification['Modification']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'User Id'); ?></dt>
		<dd>
			<?php echo h($modification['Modification']['user_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Model'); ?></dt>
		<dd>
			<?php echo h($modification['Modification']['model']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Foreign Key'); ?></dt>
		<dd>
			<?php echo h($modification['Modification']['foreign_key']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Action'); ?></dt>
		<dd>
			<?php echo h($modification['Modification']['action']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'User Details'); ?></dt>
		<dd>
			<?php echo h($modification['Modification']['user_details']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Content Before'); ?></dt>
		<dd>
			<?php echo h($modification['Modification']['content_before']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Content After'); ?></dt>
		<dd>
			<?php echo h($modification['Modification']['content_after']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('cms', 'Created'); ?></dt>
		<dd>
			<?php echo h($modification['Modification']['created']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __d('cms', 'Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__d('cms', 'Edit Modification'), array('action' => 'edit', $modification['Modification']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__d('cms', 'Delete Modification'), array('action' => 'delete', $modification['Modification']['id']), null, __d('cms', 'Are you sure you want to delete # %s?', $modification['Modification']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__d('cms', 'List Modifications'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__d('cms', 'New Modification'), array('action' => 'add')); ?> </li>
	</ul>
</div>
