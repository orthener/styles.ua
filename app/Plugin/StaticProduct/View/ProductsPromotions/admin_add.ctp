<?php $this->set('title_for_layout', __d('cms', 'Editing') . ' &bull; ' . __d('cms', 'Promocja produktu')); ?><h2><?php echo __d('cms', 'Nowa promocja'); ?></h2>

<div class="productPromotions form">
    <?php echo $this->Form->create('ProductsPromotion'); ?>
    <?php echo $this->Element('ProductsPromotions/fields'); ?>
    <?php echo $this->Form->end(__d('cms', 'Submit')); ?>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <?php echo $this->Permissions->link(__d('cms', 'Lista promocji produktu'), array('action' => 'index', $this->params->pass[0]), array('outter' => '<li>%s</li>')); ?>
    </ul>
</div>