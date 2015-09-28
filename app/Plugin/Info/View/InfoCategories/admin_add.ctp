<?php $this->set('title_for_layout', __d('cms', 'Editing') . ' &bull; ' . __d('cms', 'Article Categories')); ?>
<h2><?php echo __d('cms', 'Admin Add Article Category'); ?></h2>

<div class="infoCategories form">
    <?php echo $this->Form->create('InfoCategory'); ?>
    <?php echo $this->Element('InfoCategories/fields'); ?>
    <?php echo $this->Form->end(__d('cms', 'Submit')); ?>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <?php echo $this->Permissions->link(__d('cms', 'List Article Categories'), array('action' => 'index'), array('outter' => '<li>%s</li>')); ?>
    </ul>
</div>
