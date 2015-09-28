<div class="baners form">
<h2><?php echo __d('cms', 'Dodawanie banera'); ?></h2>
<?php echo $this->Form->create('Baner', array('type' => 'file'));?>
    <?php echo $this->element('form', array('plugin' => 'baner', 'desc' => __d('cms', 'Nowy baner'))); ?>
<?php echo $this->Form->end(__d('cms', 'Submit'));?>
</div>
<div class="actions">
	<h3><?php __d('cms', 'Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__d('cms', 'List Baners'), array('action' => 'index'));?></li>
	</ul>
</div>