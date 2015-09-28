<div class="newsletters form">
<?php echo $this->Form->create('Newsletter');?>
	<fieldset>
 		<legend><?php echo  __d('cms', 'Admin Add Newsletter'); ?></legend>
	<?php
		echo $this->Form->input('email');
	?>
	</fieldset>
<?php echo $this->Form->end(__d('cms', 'Submit'));?>
</div>
<div class="actions">
	<h3><?php echo  __d('cms', 'Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__d('cms', 'List Newsletters'), array('action' => 'index'));?></li>
	</ul>
</div>