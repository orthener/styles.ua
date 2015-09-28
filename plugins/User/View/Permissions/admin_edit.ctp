<div class="permissions form">
<?php echo $this->Form->create('Permission');?>
	<fieldset>
 		<legend><?php echo __d('cms', 'Admin Edit %s', 'Permission'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('User');
		echo $this->Form->input('Group');
	?>
	</fieldset>
<?php echo $this->Form->end(__d('cms', 'Submit'));?>
</div>
<div class="actions">
	<h3><?php echo  __d('cms', 'Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__d('cms', 'Delete'), array('action' => 'delete', $this->Form->value('Permission.id')), null, __d('cms', 'Are you sure you want to delete # %s?', $this->Form->value('Permission.id'))); ?></li>
		<li><?php echo $this->Html->link(__d('cms', 'List %s', 'Permissions'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__d('cms', 'List %s', 'Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__d('cms', 'New %s', 'User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__d('cms', 'List %s', 'Groups'), array('controller' => 'groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__d('cms', 'New %s', 'Group'), array('controller' => 'groups', 'action' => 'add')); ?> </li>
	</ul>
</div>