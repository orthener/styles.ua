<?php $this->set('title_for_layout', __d('cms', 'Adding') . ' &bull; ' . __d('cms', 'Products')); ?><h2><?php echo __d('cms', 'Admin Add Product'); ?></h2>

<div class="products form">
    <?php echo $this->Form->create('Product', array('type' => 'file')); ?>
    <?php echo $this->Element('Products/fields'); ?>
    <?php echo $this->Form->end(__d('cms', 'Submit')); ?>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <?php echo $this->Permissions->link(__d('cms', 'List Products'), array('action' => 'index'), array('outter' => '<li>%s</li>')); ?>
    </ul>
</div>
