<?php $this->set('title_for_layout', __d('cms', 'Editing') . ' &bull; ' . __d('cms', 'Info Pages')); ?><h2><?php echo __d('cms', 'Add Info Page'); ?></h2>

<div class="infoPages form">
    <?php echo $this->Form->create('InfoPage'); ?>
    <?php echo $this->Element('InfoPages/fields'); ?>
    <?php echo $this->Form->end(__d('cms', 'Submit')); ?>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <?php echo $this->Permissions->link(__d('cms', 'List Info Pages'), array('action' => 'index'), array('outter' => '<li>%s</li>')); ?>
    </ul>
</div>
