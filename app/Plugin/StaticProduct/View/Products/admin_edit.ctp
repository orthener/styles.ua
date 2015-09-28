<?php $this->set('title_for_layout', __d('cms', 'Editing') . ' &bull; ' . __d('cms', 'Products')); ?><h2><?php echo __d('cms', 'Admin Edit Product'); ?></h2>

<div class="products form">
    <?php echo $this->Form->create('Product', array('type' => 'file')); ?>
    <?php echo $this->Form->input('id'); ?>
    <?php echo $this->Element('Products/fields'); ?>
    <?php echo $this->Form->end(__d('cms', 'Submit')); ?>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <?php echo $this->Permissions->postLink(__d('cms', 'Delete'), array('action' => 'delete', $this->Form->value('Product.id')), array('outter' => '<li>%s</li>'), __('Are you sure you want to delete # %s?', $this->Form->value('Product.title'))); ?> 
        <?php echo $this->Permissions->link(__d('cms', 'List Products'), array('action' => 'index'), array('outter' => '<li>%s</li>')); ?>
        <?php echo $this->Permissions->link(__('Zdjęcia'), array('plugin' => 'photo', 'controller' => 'photos', 'action' => 'index', 'StaticProduct.Product', $this->Form->value('Product.id')), array('outter' => '<li>%s</li>')); ?>
        <?php echo $this->Permissions->link(__d('cms', 'List Product Promotions'), array('controller' => 'products_promotions', 'action' => 'index', $this->Form->value('Product.id')), array('outter' => '<li>%s</li>','confirm'=>__d('cms','Uwaga przed przejściem do promocji należy zapisać zmiany'))); ?>

        <?php //echo $this->Permissions->link(__d('cms', 'List Photos'), array('plugin' => false, 'controller' => 'photos', 'action' => 'index'), array('outter'=>'<li>%s</li>')); ?> 
        <?php //echo $this->Permissions->link(__d('cms', 'New Photo'), array('plugin' => false, 'controller' => 'photos', 'action' => 'add'), array('outter'=>'<li>%s</li>')); ?> 
        <?php //echo $this->Permissions->link(__d('cms', 'List Product Categories'), array('plugin' => false, 'controller' => 'product_categories', 'action' => 'index'), array('outter'=>'<li>%s</li>')); ?> 
        <?php //echo $this->Permissions->link(__d('cms', 'New Product Category'), array('plugin' => false, 'controller' => 'product_categories', 'action' => 'add'), array('outter'=>'<li>%s</li>')); ?> 
    </ul>
</div>


