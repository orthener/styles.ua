<div class="modifications form">
    <?php echo $this->Form->create('Modification'); ?>
	<?php echo $this->Form->input('id'); ?>
	<?php echo $this->Element('Modifications/fields', array('desc' =>  __d('cms', 'Edit Modification'))); ?>
	<?php echo $this->Form->end(__d('cms', 'Submit')); ?>
</div>
<div class="actions">
    <h3><?php echo __d('cms', 'Actions'); ?></h3>
    <ul>
        <?php echo $this->Permissions->postLink(__d('cms', 'Delete'), array('plugin' => false, 'action' => 'delete', $this->Form->value('Modification.id')), array('outter'=>'<li>%s</li>'), __d('cms', 'Are you sure you want to delete # %s?', $this->Form->value('Modification.user_id'))); ?> 
        <?php echo $this->Permissions->link(__d('cms', 'List Modifications'), array('plugin' => false, 'action' => 'index'), array('outter'=>'<li>%s</li>')); ?>
            </ul>
</div>
