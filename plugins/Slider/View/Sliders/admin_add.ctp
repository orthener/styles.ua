<?php $this->set('title_for_layout', __d('cms', 'Editing').' &bull; '.__d('cms', 'Sliders')); ?><h2><?php echo __d('cms', 'Admin Add Slider'); ?></h2>

<div class="sliders form">
    <?php echo $this->Form->create('Slider', array('type' => 'file')); ?>
	<?php echo $this->Element('Sliders/fields'); ?>
	<?php echo $this->Form->end(__d('cms', 'Submit')); ?>
</div>
<div class="actions">
    <h3><?php echo __d('cms', 'Actions'); ?></h3>
    <ul>
        <?php echo $this->Permissions->link(__d('cms', 'List Sliders'), array('action' => 'index'), array('outter'=>'<li>%s</li>')); ?>
            </ul>
</div>
