<?php $this->set('title_for_layout', __d('cms', 'Editing') . ' &bull; ' . __d('cms', 'Info Tags')); ?><h2><?php echo __d('cms', 'Admin Add Info Tag'); ?></h2>

<div class="infoTags form">
    <?php echo $this->Form->create('InfoTag'); ?>
    <?php echo $this->Element('InfoTags/fields'); ?>
    <?php echo $this->Form->end(__d('cms', 'Submit')); ?>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <?php echo $this->Permissions->link(__d('cms', 'List Info Tags'), array('action' => 'index'), array('outter' => '<li>%s</li>')); ?>
    </ul>
</div>
