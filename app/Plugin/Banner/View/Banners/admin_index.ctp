<?php $this->set('title_for_layout', __d('cms', 'List') . ' &bull; ' . __d('cms', 'Banners')); ?>
<div class="banners index">
    <h2><span></span><?php echo __d('cms', 'Banners'); ?></h2>
    <?php echo $this->Element('Banners/table_index'); ?> 
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <?php echo $this->Permissions->link(__d('cms', 'New Banner'), array('action' => 'add'), array('outter' => '<li>%s</li>')); ?>
    </ul>
</div>
