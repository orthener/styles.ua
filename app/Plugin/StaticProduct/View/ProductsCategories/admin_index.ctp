<?php $this->set('title_for_layout', __d('cms', 'List') . ' &bull; ' . __d('cms', 'Product Categories')); ?>
<div class="productCategories index">
    <h2><span></span><?php echo __d('cms', 'Product Categories'); ?></h2>
    <?php echo $this->Element('ProductsCategories/table_index'); ?> 
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <?php echo $this->Permissions->link(__d('cms', 'New Product Category'), array('action' => 'add'), array('outter' => '<li>%s</li>')); ?>
    </ul>
</div>
