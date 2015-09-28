<?php $this->set('title_for_layout', __d('cms', 'List') . ' &bull; ' . __d('cms', 'Promocja produktu')); ?>
<div class="productPromotions index">
    <h2><span></span><?php echo __d('cms', 'Promocje produktu'); ?></h2>
    <?php echo $this->Element('ProductsPromotions/table_index'); ?> 
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <?php echo $this->Permissions->link(__d('cms', 'Nowa promocja'), array('action' => 'add', $this->params->pass[0]), array('outter' => '<li>%s</li>')); ?>
        <?php echo $this->Permissions->link(__d('cms', 'Edytuj produkt'), array('controller'=>'products','action' => 'edit', $this->params->pass[0]), array('outter' => '<li>%s</li>')); ?>
    </ul>
</div>