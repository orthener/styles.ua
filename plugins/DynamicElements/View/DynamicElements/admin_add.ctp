<?php $this->set('title_for_layout', __d('cms', 'Nowy wycinek strony').' ('.__d('cms', 'fragment layoutu').')'); ?>

<div class="dynamicElements form">
<h2><?php echo  __d('cms', 'Nowy wycinek strony'); ?> (<?php echo  __d('cms', 'fragment layoutu'); ?>)</h2>
<?php echo $this->Form->create('DynamicElement');?>
	<fieldset>
 		<legend><?php echo  __d('cms', 'Dodaj wycinek strony'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('slug');
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

		<li><?php echo $this->Html->link(__d('cms', 'Lista wycinków'), array('action' => 'index'));?></li>
	</ul>
</div>