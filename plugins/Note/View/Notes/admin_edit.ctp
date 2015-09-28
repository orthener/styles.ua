<div class="notes form">
    <?php echo $this->Form->create('Note'); ?>
	<?php echo $this->Form->input('id'); ?>
	<?php echo $this->Element('Note.Notes/fields', array('desc' =>  __d('cms', 'Admin Edit Note'))); ?>
	<?php echo $this->Form->end(__d('cms', 'Submit')); ?>
</div>
<div class="actions">
    <h3><?php echo __d('cms', 'Actions'); ?></h3>
    <ul>
        <?php echo $this->Permissions->postLink(__d('cms', 'Delete'), array('plugin' => false, 'action' => 'delete', $this->Form->value('Note.id')), array('outter'=>'<li>%s</li>'), __d('cms', 'Are you sure you want to delete # %s?', $this->Form->value('Note.title'))); ?> 
        <?php echo $this->Permissions->link(__d('cms', 'List Notes'), array('plugin' => false, 'action' => 'index'), array('outter'=>'<li>%s</li>')); ?>
        <?php //echo $this->Permissions->link(__d('cms', 'List Users'), array('plugin' => false, 'controller' => 'users', 'action' => 'index'), array('outter'=>'<li>%s</li>')); ?> 
		<?php //echo $this->Permissions->link(__d('cms', 'New User'), array('plugin' => false, 'controller' => 'users', 'action' => 'add'), array('outter'=>'<li>%s</li>')); ?> 
    </ul>
</div>
