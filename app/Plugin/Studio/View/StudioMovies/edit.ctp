<?php $this->set('title_for_layout', __d('cms', 'Adding').' &bull; '.__d('cms', 'Studio Movies')); ?><h2><?php echo __d('cms', 'Edit Studio Movie'); ?></h2>

<div class="studioMovies form">
    <?php echo $this->Form->create('StudioMovie', array('type' => 'file')); ?>
	<?php echo $this->Form->input('id'); ?>
	<?php echo $this->Element('StudioMovies/fields'); ?>
	<?php echo $this->Form->end(__d('cms', 'Submit')); ?>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <?php echo $this->Permissions->postLink(__d('cms', 'Delete'), array('action' => 'delete', $this->Form->value('StudioMovie.id')), array('outter'=>'<li>%s</li>'), __('Are you sure you want to delete # %s?', $this->Form->value('StudioMovie.name'))); ?> 
        <?php echo $this->Permissions->link(__d('cms', 'List Studio Movies'), array('action' => 'index'), array('outter'=>'<li>%s</li>')); ?>
            </ul>
</div>
