<div class="categories form">
<?php echo $this->Form->create('Category');?>
	<?php echo $this->element('Categories/form'); ?>
<?php echo $this->Form->end(__d('cms', 'Submit'));?>
</div>
<div class="actions">
	<h3><?php echo  __d('cms', 'Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__d('cms', 'List Categories'), array('action' => 'index'));?></li>
	</ul>
</div>