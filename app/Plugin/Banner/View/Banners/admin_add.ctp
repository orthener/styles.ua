<?php $this->set('title_for_layout', __d('cms', 'Editing').' &bull; '.__d('cms', 'Banners')); ?><h2><?php echo __d('cms', 'Admin Add Banner'); ?></h2>

<div class="banners form">
    <?php echo $this->Form->create('Banner', array('type'=>'file')); ?>
	<?php echo $this->Element('Banners/fields'); ?>
	<?php echo $this->Form->end(__d('cms', 'Submit')); ?>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <?php echo $this->Permissions->link(__d('cms', 'List Banners'), array('action' => 'index'), array('outter'=>'<li>%s</li>')); ?>
            </ul>
</div>
