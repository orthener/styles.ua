<?php $this->set('title_for_layout', __d('cms', 'Editing') . ' &bull; ' . __d('cms', 'Brands')); ?><h2><?php echo __d('cms', 'Admin Add Brand'); ?></h2>

<div class="brands form">
    <?php echo $this->Form->create('Brand', array('type' => 'file')); ?>
    <?php echo $this->Element('Brands/fields'); ?>
    <?php echo $this->Form->end(__d('cms', 'Submit')); ?>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <?php echo $this->Permissions->link(__d('cms', 'List Brands'), array('action' => 'index'), array('outter' => '<li>%s</li>')); ?>
    </ul>
</div>
