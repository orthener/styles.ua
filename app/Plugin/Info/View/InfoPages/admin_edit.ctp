<?php $this->set('title_for_layout', __d('cms', 'Adding') . ' &bull; ' . __d('cms', 'Article Pages')); ?><h2><?php echo __d('cms', 'Admin Edit Article Page'); ?></h2>

<div class="infoPages form">
    <?php echo $this->Form->create('InfoPage'); ?>
    <?php echo $this->Form->input('id'); ?>
    <?php echo $this->Element('InfoPages/fields'); ?>
    <?php echo $this->Form->end(__d('cms', 'Submit')); ?>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <?php echo $this->Permissions->postLink(__d('cms', 'Delete'), array('action' => 'delete', $this->Form->value('InfoPage.id')), array('outter' => '<li>%s</li>'), __('Are you sure you want to delete # %s?', $this->Form->value('InfoPage.name'))); ?> 
        <?php echo $this->Permissions->link(__d('cms', 'List Article Pages'), array('action' => 'index'), array('outter' => '<li>%s</li>')); ?>
    </ul>
</div>
