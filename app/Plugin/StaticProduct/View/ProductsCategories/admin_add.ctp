<?php $this->set('title_for_layout', __d('cms', 'Editing').' &bull; '.__d('cms', 'Product Categories')); ?><h2><?php echo __d('cms', 'Admin Add Product Category'); ?></h2>

<div class="productCategories form">
    <?php echo $this->Form->create('ProductsCategory'); ?>
	<?php echo $this->Element('ProductsCategories/fields'); ?>
	<?php echo $this->Form->end(__d('cms', 'Submit')); ?>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <?php echo $this->Permissions->link(__d('cms', 'List Product Categories'), array('action' => 'index'), array('outter'=>'<li>%s</li>')); ?>
            </ul>
</div>
