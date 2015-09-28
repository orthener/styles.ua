<?php $this->set('title_for_layout', __d('cms', 'List') . ' &bull; ' . __d('cms', 'Brands')); ?><div class="brands index">

    <?php echo $this->Element('Brands/table_index'); ?> 
    <?php echo $this->Element('cms/paginator'); ?></div>

<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <?php echo $this->Permissions->link(__d('cms', 'New Brand'), array('action' => 'add'), array('outter' => '<li>%s</li>')); ?>
        <?php echo $this->Permissions->link(__('Sortowanie'), array('plugin' => 'sort', 'controller' => 'sorts', 'action' => 'sort', 'Brand'), array('outter' => '<li>%s</li>')); ?>
    </ul>
</div>
