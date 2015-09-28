<div class="regions form">
    <?php echo $this->Form->create('Region'); ?>
	<?php echo $this->Element('Region.Regions/fields', array('desc' => __d('cms', 'Admin Add Region'))); ?>
	<?php echo $this->Form->end(__d('cms', 'Submit')); ?>
</div>
<div class="actions">
    <h3><?php echo __d('cms', 'Actions'); ?></h3>
    <ul>
        <?php echo $this->Permissions->link(__d('cms', 'List Regions'), array('plugin' => false, 'action' => 'index'), array('outter'=>'<li>%s</li>')); ?>
            </ul>
</div>
