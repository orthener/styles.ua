<?php $this->set('title_for_layout', __d('cms', 'Adding') . ' &bull; ' . __d('cms', 'Banners')); ?><h2><?php echo __d('cms', 'Admin Edit Product Category'); ?></h2>

<div class="banners form">
    <?php echo $this->Form->create('Banner', array('type' => 'file')); ?>
    <?php echo $this->Form->input('id'); ?>
    <?php echo $this->Element('Banners/fields'); ?>
    <?php echo $this->Form->end(__d('cms', 'Submit')); ?>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <?php echo $this->Permissions->postLink(__d('cms', 'Delete'), array('action' => 'delete', $this->Form->value('Banner.id')), array('outter' => '<li>%s</li>'), __('Are you sure you want to delete # %s?', $this->Form->value('Banner.name'))); ?> 
        <?php echo $this->Permissions->link(__d('cms', 'List Banners'), array('action' => 'index'), array('outter' => '<li>%s</li>')); ?>
    </ul>
</div>
