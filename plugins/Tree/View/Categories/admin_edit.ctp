<div class="categories form">
<?php echo $this->Form->create('Category');?>
	<?php
		echo $this->Form->input('id');
		echo $this->element('categories/form');
	?>
<?php echo $this->Form->end(__d('cms', 'Zapisz'));?>
</div>
<div class="actions">
	<h3><?php echo  __d('cms', 'Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__d('cms','Lista linków - Menu publiczne'), array('admin' => false, 'plugin' => 'tree', 'controller' => 'tree', 'action' => 'index', 'Category'));?></li>
	</ul>
</div>