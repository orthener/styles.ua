<?php $this->set('title_for_layout', __d('cms', 'Edycja wycinka strony').' ('.__d('cms', 'fragmentu layoutu').')'); ?>


<div class="dynamicElements form">
<h2><?php echo  __d('cms', 'Edycja wycinka strony'); ?> (<?php echo  __d('cms', 'fragmentu layoutu'); ?>)</h2>
<?php echo $this->Form->create('DynamicElement');?>
	<fieldset>
 		<legend><?php echo  __d('cms', 'Edytuj wycinek strony'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('slug', array('disabled'=>'disabled'));
		echo $this->Form->input('style');
	?>
	</fieldset>
    <fieldset class="textareaFull">
        <legend><?php echo __d('cms', 'Zawartość'); ?></legend>
        <?php echo $this->FebTinyMce->input('content', array('label' => false,'id'=>'contentTiny'),'full'); ?>
    </fieldset>

<?php echo $this->Form->end(__d('cms', 'Submit'));?>
</div>
<div class="actions">
	<h3><?php echo  __d('cms', 'Actions'); ?></h3>
	<ul>
<?php /* ?>
		<li><?php echo $this->Html->link(__d('cms', 'Usuń'), array('action' => 'delete', $this->Form->value('DynamicElement.id')), null, sprintf(__d('cms', 'Are you sure you want to delete # %s?'), $this->Form->value('DynamicElement.id'))); ?></li>
<?php /**/ ?>
		<li><?php echo $this->Html->link(__d('cms', 'Lista wycinków'), array('action' => 'index'));?></li>
	</ul>
</div>