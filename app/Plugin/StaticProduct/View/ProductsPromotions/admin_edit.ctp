<?php $this->set('title_for_layout', __d('cms', 'Adding') . ' &bull; ' . __d('cms', 'Promocja produktu')); ?><h2><?php echo __d('cms', 'Admin Edit Product Promotion'); ?></h2>

<div class="productPromotions form">
    <?php echo $this->Form->create('ProductsPromotion'); ?>
    <?php echo $this->Form->input('id'); ?>
    <?php echo $this->Element('ProductsPromotions/fields'); ?>
    <?php echo $this->Form->end(__d('cms', 'Submit')); ?>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <?php echo $this->Permissions->postLink(__d('cms', 'Delete'), array('action' => 'delete', $this->Form->value('ProductsPromotion.id')), array('outter' => '<li>%s</li>'), __('Are you sure you want to delete # %s?', $this->Form->value('ProductsPromotion.name'))); ?> 
        <?php echo $this->Permissions->link(__d('cms', 'Lista promocji produktu'), array('action' => 'index', $this->params->pass[0]), array('outter' => '<li>%s</li>')); ?>
    </ul>
</div>
