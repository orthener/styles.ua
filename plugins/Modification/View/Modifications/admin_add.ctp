<div class="modifications form">
    <?php echo $this->Form->create('Modification'); ?>
	<?php echo $this->Element('Modifications.Modifications/fields', array('desc' => __d('cms', 'Admin Add Modification'))); ?>
	<?php echo $this->Form->end(__d('cms', 'Submit')); ?>
</div>
<div class="actions">
    <h3><?php echo __d('cms', 'Actions'); ?></h3>
    <ul>
        <?php echo $this->Permissions->link(__d('cms', 'List Modifications'), array('plugin' => false, 'action' => 'index'), array('outter'=>'<li>%s</li>')); ?>
            </ul>
</div>
