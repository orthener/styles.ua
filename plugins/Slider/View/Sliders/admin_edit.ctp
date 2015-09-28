<?php $this->set('title_for_layout', __d('cms', 'Adding').' &bull; '.__d('cms', 'Sliders')); ?><h2><?php echo __d('cms', 'Admin Edit Slider'); ?></h2>

<div class="sliders form">
    <?php echo $this->Form->create('Slider', array('type' => 'file')); ?>
	<?php echo $this->Form->input('id'); ?>
	<?php echo $this->Element('Sliders/fields'); ?>
	<?php echo $this->Form->end(__d('cms', 'Submit')); ?>
</div>
<div class="actions">
    <h3><?php echo __d('cms', 'Actions'); ?></h3>
    <ul>
        <?php echo $this->Permissions->postLink(__d('cms', 'Delete'), array('action' => 'delete', $this->Form->value('Slider.id')), array('outter'=>'<li>%s</li>'), __d('cms', 'Are you sure you want to delete # %s?', $this->Form->value('Slider.name'))); ?> 
        <?php echo $this->Permissions->link(__d('cms', 'List Sliders'), array('action' => 'index'), array('outter'=>'<li>%s</li>')); ?>
            </ul>
</div>
