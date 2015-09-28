<div class="comments form">
<?php echo $this->Form->create('Comment');?>
	<fieldset>
 		<legend><?php echo  __d('cms', 'Add Comment'); ?></legend>
	<?php
		echo $this->Form->input('desc');
		echo $this->Form->input('active');
		echo $this->Form->input('page_id');
		echo $this->Form->input('name');
	?>
	</fieldset>
<?php echo $this->Form->end(__d('cms', 'Submit'));?>
</div>
<div class="actions">
	<h3><?php echo  __d('cms', 'Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__d('cms', 'List Comments'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__d('cms', 'List Albums'), array('controller' => 'albums', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__d('cms', 'New Album'), array('controller' => 'albums', 'action' => 'add')); ?> </li>
    </ul>
</div>