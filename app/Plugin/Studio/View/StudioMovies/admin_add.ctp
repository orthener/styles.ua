<?php $this->set('title_for_layout', __d('cms', 'Editing') . ' &bull; ' . __d('cms', 'Studio Movies')); ?>
<h2><?php echo __d('cms', 'Admin Add Studio Movie'); ?></h2>

<div class="studioMovies form">
    <?php echo $this->Form->create('StudioMovie', array('type' => 'file')); ?>
    <?php echo $this->Element('StudioMovies/fields'); ?>
    <?php echo $this->Form->end(__d('cms', 'Submit')); ?>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <?php echo $this->Permissions->link(__d('cms', 'List Studio Movies'), array('action' => 'index'), array('outter' => '<li>%s</li>')); ?>
    </ul>
</div>
