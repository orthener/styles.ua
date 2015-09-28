<div class="baners form">
    <h2><?php echo __d('cms', 'Edycja banera'); ?></h2>
<?php echo $this->Form->create('Baner', array('type' => 'file'));?>
    <?php echo $this->Form->input('id'); ?>
    <?php echo $this->element('form', array('plugin' => 'baner', 'desc' => __d('cms', 'Edycja banera'))); ?>
<?php echo $this->Form->end(__d('cms', 'Submit'));?>
</div>
<div class="actions">
	<h3><?php __d('cms', 'Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__d('cms', 'Delete'), array('action' => 'delete', $this->Form->value('Baner.id')), null, __d('cms', 'Are you sure you want to delete # %s?', $this->Form->value('Baner.id'))); ?></li>
		<li><?php echo $this->Html->link(__d('cms', 'List Baners'), array('action' => 'index'));?></li>
	</ul>
</div>