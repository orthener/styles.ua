<?php if(!empty($add_params)):
    $this->set('title_for_layout', __d('cms', 'Nowa pozycja » Realizacje'));
else:
    $this->set('title_for_layout', __d('cms', 'Nowa pozycja » Podstrony'));
endif; ?>

<div class="categories form">
<?php echo $this->Form->create('Page',array('type'=>'file')); ?>

	<?php echo $this->element('Pages/fields'); ?>
	
<?php echo $this->Form->end('Wyślij'); ?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__d('cms', 'Lista stron'), array('action'=>'index'));?></li>
	</ul>
</div>
